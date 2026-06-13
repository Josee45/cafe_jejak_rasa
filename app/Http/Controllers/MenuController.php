<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\PesananItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Illuminate\Validation\Rule;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $categoryOptions = Menu::categoryOptions(true);
        $kategori = Menu::normalizeCategory($request->query('kategori', 'semua'));

        if (! Schema::hasTable('menus')) {
            $menus = collect();
        } elseif ($kategori && $kategori != 'semua') {
            $menus = Menu::where('kategori', $kategori)->latest()->get();
        } else {
            $menus = Menu::latest()->get();
        }

        return view('menu.index', compact('menus', 'kategori', 'categoryOptions'));
    }

    public function create()
    {
        $categoryOptions = Menu::categoryOptions();

        return view('menu.tambah', compact('categoryOptions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'kategori' => ['required', Rule::in(array_keys(Menu::categoryOptions()))],
            'harga' => 'required|numeric',
            'stok' => 'nullable|integer|min:0',
            'tersedia' => 'nullable|boolean',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:10248',
        ]);

        $namaGambar = null;
        $stok = $request->filled('stok') ? (int) $request->stok : null;
        $tersedia = $request->boolean('tersedia');

        if ($stok !== null && $stok <= 0) {
            $tersedia = false;
        }

        if ($request->hasFile('gambar')) {
            $namaGambar = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/menu'), $namaGambar);
        }

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'gambar' => $namaGambar,
            'tersedia' => $tersedia,
            'stok' => $stok,
        ]);

        return redirect()->route('data.menu')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);
        $categoryOptions = Menu::categoryOptions();

        return view('menu.edit', compact('menu', 'categoryOptions'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required',
            'kategori' => ['required', Rule::in(array_keys(Menu::categoryOptions()))],
            'harga' => 'required|numeric',
            'stok' => 'nullable|integer|min:0',
            'tersedia' => 'nullable|boolean',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:10248',
        ]);

        $menu = Menu::findOrFail($id);

        $namaGambar = $menu->gambar;
        $stok = $request->filled('stok') ? (int) $request->stok : null;
        $tersedia = $request->boolean('tersedia');

        if ($stok !== null && $stok <= 0) {
            $tersedia = false;
        }

        if ($request->hasFile('gambar')) {
            $namaGambar = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/menu'), $namaGambar);
        }

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'gambar' => $namaGambar,
            'tersedia' => $tersedia,
            'stok' => $stok,
        ]);

        return redirect()->route('data.menu')
            ->with('success', 'Menu berhasil diedit');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

        if (PesananItem::where('menu_id', $menu->id)->exists()) {
            $menu->update([
                'tersedia' => false,
                'stok' => 0,
            ]);

            return redirect()->route('data.menu')
                ->with('success', 'Menu sudah punya riwayat pesanan, jadi dinonaktifkan agar data transaksi tetap aman.');
        }

        if ($menu->gambar && file_exists(public_path('images/menu/' . $menu->gambar))) {
            unlink(public_path('images/menu/' . $menu->gambar));
        } elseif ($menu->gambar && file_exists(public_path('images/' . $menu->gambar))) {
            unlink(public_path('images/' . $menu->gambar));
        }

        $menu->delete();

        return redirect()->route('data.menu')
            ->with('success', 'Menu berhasil dihapus');
    }
}
