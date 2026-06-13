@extends('layouts.cafe')

@section('title', 'Edit Menu - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <section class="panel form-card">
            <p class="eyebrow">Admin</p>
            <h2>Edit Menu</h2>
            <p class="muted" style="line-height:1.6;">Perbarui informasi menu yang sudah ada.</p>

            <div style="margin-top:20px;">
                @include('partials.alerts')
            </div>

            <form action="{{ route('menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="field">
                    <label for="nama_menu">Nama Menu</label>
                    <input id="nama_menu" type="text" name="nama_menu" value="{{ old('nama_menu', $menu->nama_menu) }}" required>
                </div>

                <div class="field">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" required>
                        @foreach($categoryOptions as $value => $label)
                            <option value="{{ $value }}" @selected(old('kategori', $menu->kategori) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="harga">Harga</label>
                    <input id="harga" type="number" name="harga" value="{{ old('harga', $menu->harga) }}" min="0" required>
                </div>

                <div class="field">
                    <label>Gambar Saat Ini</label>
                    @if($menu->gambar)
                        <img class="thumb" style="width:130px; height:96px;" src="{{ $menu->image_url }}" alt="{{ $menu->nama_menu }}">
                    @else
                        <p class="muted">Tidak ada gambar.</p>
                    @endif
                </div>

                <div class="field">
                    <label for="gambar">Ganti Gambar</label>
                    <input id="gambar" type="file" name="gambar" accept="image/png,image/jpeg">
                </div>

                <div class="actions">
                    <button type="submit" class="btn">Update</button>
                    <a href="{{ route('data.menu') }}" class="btn secondary">Kembali</a>
                </div>
            </form>
        </section>
    </main>
@endsection
