<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class PesananAdminController extends Controller
{
    public function dataPesanan(Request $request)
    {
        $statusOptions = Pesanan::STATUS_OPTIONS;
        $paymentStatusOptions = Pesanan::PAYMENT_STATUS_OPTIONS;

        $pesanan = Pesanan::with(['pelanggan', 'items.menu'])
            ->when($request->filled('q'), function ($query) use ($request) {
                $rawKeyword = trim((string) $request->q);
                $keyword = '%' . $request->q . '%';

                $query->where(function ($query) use ($keyword, $rawKeyword) {
                    if (ctype_digit($rawKeyword)) {
                        $query->where('id', (int) $rawKeyword);
                    }

                    $query->orWhereHas('pelanggan', function ($query) use ($keyword) {
                            $query->where('name', 'like', $keyword)
                                ->orWhere('email', 'like', $keyword);
                        })
                        ->orWhereHas('items.menu', function ($query) use ($keyword) {
                            $query->where('nama_menu', 'like', $keyword);
                        });
                });
            })
            ->when($request->filled('status') && array_key_exists($request->status, $statusOptions), function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->filled('pembayaran') && array_key_exists($request->pembayaran, $paymentStatusOptions), function ($query) use ($request) {
                $query->where('status_pembayaran', $request->pembayaran);
            })
            ->when($request->filled('tanggal'), function ($query) use ($request) {
                $query->whereDate('created_at', $request->tanggal);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('data_pesanan', compact('pesanan', 'statusOptions', 'paymentStatusOptions'));
    }

    public function updateStatus(Request $request, Pesanan $pesanan)
    {
        $data = $request->validate([
            'status' => ['required', Rule::in(array_keys(Pesanan::STATUS_OPTIONS))],
        ]);

        DB::transaction(function () use ($pesanan, $data) {
            $pesanan->load('items');

            if ($pesanan->status !== 'dibatalkan' && $data['status'] === 'dibatalkan') {
                $this->restoreStock($pesanan);
            }

            if ($pesanan->status === 'dibatalkan' && $data['status'] !== 'dibatalkan') {
                $this->reserveStock($pesanan);
            }

            $pesanan->update([
                'status' => $data['status'],
            ]);
        });

        return back()->with('success', 'Status pesanan diperbarui.');
    }

    public function updatePayment(Request $request, Pesanan $pesanan)
    {
        $data = $request->validate([
            'status_pembayaran' => ['required', Rule::in(array_keys(Pesanan::PAYMENT_STATUS_OPTIONS))],
        ]);

        $payload = [
            'status_pembayaran' => $data['status_pembayaran'],
        ];

        if ($data['status_pembayaran'] === 'lunas') {
            $payload['dibayar_pada'] = $pesanan->dibayar_pada ?? now();

            if ($pesanan->status === 'pending') {
                $payload['status'] = 'diproses';
            }
        } else {
            $payload['dibayar_pada'] = null;

            if ($data['status_pembayaran'] === 'belum_bayar') {
                $payload['metode_pembayaran'] = null;
            }
        }

        $pesanan->update($payload);

        return back()->with('success', 'Status pembayaran diperbarui.');
    }

    private function restoreStock(Pesanan $pesanan): void
    {
        foreach ($pesanan->items as $item) {
            $menu = Menu::whereKey($item->menu_id)->lockForUpdate()->first();

            if (! $menu || $menu->stok === null) {
                continue;
            }

            $menu->update([
                'stok' => (int) $menu->stok + (int) $item->qty,
                'tersedia' => true,
            ]);
        }
    }

    private function reserveStock(Pesanan $pesanan): void
    {
        foreach ($pesanan->items as $item) {
            $menu = Menu::whereKey($item->menu_id)->lockForUpdate()->first();

            if (! $menu) {
                throw ValidationException::withMessages([
                    'status' => 'Ada menu pesanan yang sudah tidak tersedia.',
                ]);
            }

            if (! $menu->isAvailableForOrder((int) $item->qty)) {
                throw ValidationException::withMessages([
                    'status' => "{$menu->nama_menu} tidak memiliki stok yang cukup untuk mengaktifkan pesanan ini.",
                ]);
            }

            if ($menu->stok !== null) {
                $stokBaru = max(0, (int) $menu->stok - (int) $item->qty);

                $menu->update([
                    'stok' => $stokBaru,
                    'tersedia' => $stokBaru > 0,
                ]);
            }
        }
    }
}
