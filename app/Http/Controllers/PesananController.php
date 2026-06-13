<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class PesananController extends Controller
{
    public function showForm(Request $request)
    {
        $categoryOptions = Menu::categoryOptions(true);
        $kategori = Menu::normalizeCategory($request->query('kategori', 'semua'));
        $menus = $kategori === 'semua'
            ? Menu::latest()->get()
            : Menu::where('kategori', $kategori)->latest()->get();

        $cart = session()->get('cart', []);
        $cartItems = collect($cart)->map(function ($qty, $menuId) {
            $menu = Menu::find($menuId);

            if (! $menu) {
                return null;
            }

            return [
                'menu' => $menu,
                'qty' => (int) $qty,
                'subtotal' => (float) $menu->harga * (int) $qty,
            ];
        })->filter()->values();

        $cartTotal = $cartItems->sum('subtotal');

        return view('pesan', compact('menus', 'cartItems', 'cartTotal', 'kategori', 'categoryOptions'));
    }

    public function riwayat()
    {
        $pesanan = Pesanan::with(['items.menu'])
            ->where('pelanggan_id', Auth::guard('pelanggan')->id())
            ->latest()
            ->paginate(10);

        return view('riwayat_pesanan', compact('pesanan'));
    }

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => ['required', 'integer', 'exists:menus,id'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);
        $menuId = (int) $request->menu_id;
        $qty = (int) $request->qty;
        $menu = Menu::findOrFail($menuId);
        $requestedQty = ($cart[$menuId] ?? 0) + $qty;

        if (! $menu->isAvailableForOrder($requestedQty)) {
            return back()->withErrors([
                'qty' => $this->stockErrorMessage($menu),
            ]);
        }

        $cart[$menuId] = $requestedQty;
        $this->saveCart($cart);

        return back()->with('success', 'Pesanan ditambahkan ke keranjang');
    }

    public function updateCart(Request $request, Menu $menu)
    {
        $data = $request->validate([
            'qty' => ['required', 'integer', 'min:0'],
        ]);

        $cart = session()->get('cart', []);
        $qty = (int) $data['qty'];

        if ($qty === 0) {
            unset($cart[$menu->id]);
            $this->saveCart($cart);

            return back()->with('success', 'Menu dihapus dari keranjang');
        }

        if (! $menu->isAvailableForOrder($qty)) {
            return back()->withErrors([
                'qty' => $this->stockErrorMessage($menu),
            ]);
        }

        $cart[$menu->id] = $qty;
        $this->saveCart($cart);

        return back()->with('success', 'Jumlah pesanan diperbarui');
    }

    public function removeFromCart(Menu $menu)
    {
        $cart = session()->get('cart', []);
        unset($cart[$menu->id]);
        $this->saveCart($cart);

        return back()->with('success', 'Menu dihapus dari keranjang');
    }

    public function clearCart()
    {
        session()->forget('cart');

        return back()->with('success', 'Keranjang dikosongkan');
    }

    public function proses(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->route('pelanggan.pesan')->withErrors(['Keranjang masih kosong']);
        }

        $pelanggan = Auth::guard('pelanggan')->user();

        return DB::transaction(function () use ($pelanggan, $cart) {
            $total = 0;
            $items = [];

            foreach ($cart as $menuId => $qty) {
                $qty = (int) $qty;

                if ($qty < 1) {
                    continue;
                }

                $menu = Menu::whereKey((int) $menuId)->lockForUpdate()->first();

                if (! $menu || ! $menu->isAvailableForOrder($qty)) {
                    throw ValidationException::withMessages([
                        'cart' => $menu
                            ? $this->stockErrorMessage($menu)
                            : 'Ada menu di keranjang yang sudah tidak tersedia.',
                    ]);
                }

                $hargaSatuan = (float) $menu->harga;
                $subtotal = $hargaSatuan * (int) $qty;

                $items[] = compact('menu', 'qty', 'hargaSatuan', 'subtotal');

                $total += $subtotal;
            }

            if (empty($items)) {
                throw ValidationException::withMessages([
                    'cart' => 'Keranjang masih kosong.',
                ]);
            }

            $pesanan = Pesanan::create([
                'pelanggan_id' => $pelanggan->id,
                'status' => 'pending',
                'total_harga' => 0,
            ]);

            foreach ($items as $item) {
                $pesanan->items()->create([
                    'menu_id' => $item['menu']->id,
                    'qty' => $item['qty'],
                    'harga_satuan' => $item['hargaSatuan'],
                    'subtotal' => $item['subtotal'],
                ]);

                if ($item['menu']->stok !== null) {
                    $stokBaru = max(0, (int) $item['menu']->stok - $item['qty']);

                    $item['menu']->update([
                        'stok' => $stokBaru,
                        'tersedia' => $stokBaru > 0,
                    ]);
                }
            }

            $pesanan->update(['total_harga' => $total]);
            session()->forget('cart');

            return redirect()->route('struk.show', $pesanan->id);
        });
    }

    public function dataPesananAdmin()
    {
        $pesanan = Pesanan::with(['pelanggan', 'items.menu'])
            ->latest()
            ->paginate(10);
        $statusOptions = Pesanan::STATUS_OPTIONS;
        $paymentStatusOptions = Pesanan::PAYMENT_STATUS_OPTIONS;

        return view('data_pesanan', compact('pesanan', 'statusOptions', 'paymentStatusOptions'));
    }

    private function saveCart(array $cart): void
    {
        $cart = collect($cart)
            ->map(fn ($qty) => (int) $qty)
            ->filter(fn ($qty) => $qty > 0)
            ->all();

        if (empty($cart)) {
            session()->forget('cart');

            return;
        }

        session()->put('cart', $cart);
    }

    private function stockErrorMessage(Menu $menu): string
    {
        if (! $menu->isAvailableForOrder()) {
            return "{$menu->nama_menu} sedang tidak tersedia.";
        }

        return "{$menu->nama_menu} hanya tersedia {$menu->stok} porsi.";
    }
}
