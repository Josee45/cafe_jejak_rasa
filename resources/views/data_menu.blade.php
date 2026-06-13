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

            <form method="GET" action="{{ route('data.menu') }}" class="filter-form">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama atau kategori menu">

                <select name="kategori" aria-label="Filter kategori">
                    <option value="">Semua Kategori</option>
                    @foreach($categoryOptions as $value => $label)
                        <option value="{{ $value }}" @selected(request('kategori') === $value)>{{ $label }}</option>
                    @endforeach
                </select>

                <select name="tersedia" aria-label="Filter ketersediaan">
                    <option value="">Semua Status</option>
                    <option value="1" @selected(request('tersedia') === '1')>Tersedia</option>
                    <option value="0" @selected(request('tersedia') === '0')>Habis</option>
                </select>

                <button class="btn" type="submit">Filter</button>
                <a class="btn secondary" href="{{ route('data.menu') }}">Reset</a>
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>Gambar</th>
                            <th>Nama</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Stok</th>
                            <th>Status</th>
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
                                <td><span class="badge">{{ $menu->kategori_label }}</span></td>
                                <td>Rp {{ number_format($menu->harga, 0, ',', '.') }}</td>
                                <td>{{ $menu->stok === null ? 'Tidak dibatasi' : $menu->stok }}</td>
                                <td><span class="badge {{ $menu->availability_badge_class }}">{{ $menu->availability_label }}</span></td>
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
                                <td colspan="7" class="muted" style="text-align:center; padding:26px;">Belum ada menu.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($menus->hasPages())
                <div class="simple-pagination">
                    <a class="btn secondary compact {{ $menus->onFirstPage() ? 'disabled' : '' }}" @if(! $menus->onFirstPage()) href="{{ $menus->previousPageUrl() }}" @endif>Sebelumnya</a>
                    <span>Halaman {{ $menus->currentPage() }} dari {{ $menus->lastPage() }}</span>
                    <a class="btn secondary compact {{ $menus->hasMorePages() ? '' : 'disabled' }}" @if($menus->hasMorePages()) href="{{ $menus->nextPageUrl() }}" @endif>Berikutnya</a>
                </div>
            @endif
        </div>
    </main>
@endsection
