@extends('layouts.cafe')

@section('title', 'Data Menu - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <div class="container">
            <div class="page-head">
                <div>
                    <p class="eyebrow">Admin</p>
                    <h2>Data Menu</h2>
                    <p>Daftar menu yang tampil untuk pelanggan.</p>
                </div>
                <a href="{{ route('menu.create') }}" class="btn">Tambah Menu</a>
            </div>

            @include('partials.alerts')

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($menus as $menu)
                            <tr>
                                <td>
                                    <img class="thumb" src="{{ $menu->image_url }}" alt="{{ $menu->nama_menu }}">
                                </td>
                                <td><strong>{{ $menu->nama_menu }}</strong></td>
                                <td><span class="badge">{{ $menu->kategori }}</span></td>
                                <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                <td>
                                    <div class="actions">
                                        <a href="{{ route('menu.edit', $menu->id) }}" class="btn secondary">Edit</a>
                                        <form action="{{ route('menu.destroy', $menu->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn danger" onclick="return confirm('Yakin ingin menghapus menu ini?')">Hapus</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="muted" style="text-align:center; padding:26px;">Belum ada menu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </main>
@endsection
