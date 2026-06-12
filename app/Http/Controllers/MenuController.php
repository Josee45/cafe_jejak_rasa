<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class MenuController extends Controller
{
    public function index(Request $request)
    {
        $kategori = $request->kategori;

        if (! Schema::hasTable('menus')) {
            $menus = collect();
        } elseif ($kategori && $kategori != 'semua') {
            $menus = Menu::where('kategori', $kategori)->latest()->get();
        } else {
            $menus = Menu::latest()->get();
        }

        return view('menu.index', compact('menus', 'kategori'));
    }

    public function create()
    {
        return view('menu.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_menu' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:10248',
        ]);

        $namaGambar = null;

        if ($request->hasFile('gambar')) {
            $namaGambar = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/menu'), $namaGambar);
        }

        Menu::create([
            'nama_menu' => $request->nama_menu,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'gambar' => $namaGambar,
        ]);

        return redirect()->route('data.menu')
            ->with('success', 'Menu berhasil ditambahkan');
    }

    public function edit($id)
    {
        $menu = Menu::findOrFail($id);

        return view('menu.edit', compact('menu'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_menu' => 'required',
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|mimes:jpg,jpeg,png|max:10248',
        ]);

        $menu = Menu::findOrFail($id);

        $namaGambar = $menu->gambar;

        if ($request->hasFile('gambar')) {
            $namaGambar = time() . '.' . $request->gambar->extension();
            $request->gambar->move(public_path('images/menu'), $namaGambar);
        }

        $menu->update([
            'nama_menu' => $request->nama_menu,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'gambar' => $namaGambar,
        ]);

        return redirect()->route('data.menu')
            ->with('success', 'Menu berhasil diedit');
    }

    public function destroy($id)
    {
        $menu = Menu::findOrFail($id);

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
