<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\Pesanan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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

    public function addToCart(Request $request)
    {
        $request->validate([
            'menu_id' => ['required', 'integer', 'exists:menus,id'],
            'qty' => ['required', 'integer', 'min:1'],
        ]);

        $cart = session()->get('cart', []);
        $menuId = (int) $request->menu_id;
        $qty = (int) $request->qty;

        $cart[$menuId] = ($cart[$menuId] ?? 0) + $qty;
        session()->put('cart', $cart);

        return back()->with('success', 'Pesanan ditambahkan ke keranjang');
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

            $pesanan = Pesanan::create([
                'pelanggan_id' => $pelanggan->id,
                'status' => 'pending',
                'total_harga' => 0,
            ]);

            foreach ($cart as $menuId => $qty) {
                $menu = Menu::findOrFail((int) $menuId);
                $hargaSatuan = (float) $menu->harga;
                $subtotal = $hargaSatuan * (int) $qty;

                $pesanan->items()->create([
                    'menu_id' => $menu->id,
                    'qty' => (int) $qty,
                    'harga_satuan' => $hargaSatuan,
                    'subtotal' => $subtotal,
                ]);

                $total += $subtotal;
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
            ->get();

        return view('data_pesanan', compact('pesanan'));
    }
}

