@extends('layouts.cafe')

@section('title', 'Tambah Menu - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <section class="panel form-card">
            <p class="eyebrow">Admin</p>
            <h2>Tambah Menu</h2>
            <p class="muted" style="line-height:1.6;">Lengkapi data menu baru untuk ditampilkan ke pelanggan.</p>

            <div style="margin-top:20px;">
                @include('partials.alerts')
            </div>

            <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="field">
                    <label for="nama_menu">Nama Menu</label>
                    <input id="nama_menu" type="text" name="nama_menu" value="{{ old('nama_menu') }}" required>
                </div>

                <div class="field">
                    <label for="kategori">Kategori</label>
                    <select id="kategori" name="kategori" required>
                        <option value="">Pilih kategori</option>
                        @foreach(['Coffee', 'Non Coffee', 'Cemilan'] as $item)
                            <option value="{{ $item }}" @selected(old('kategori') === $item)>{{ $item }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="field">
                    <label for="harga">Harga</label>
                    <input id="harga" type="number" name="harga" value="{{ old('harga') }}" min="0" required>
                </div>

                <div class="field">
                    <label for="gambar">Gambar</label>
                    <input id="gambar" type="file" name="gambar" accept="image/png,image/jpeg">
                </div>

                <div class="actions">
                    <button type="submit" class="btn">Simpan</button>
                    <a href="{{ route('data.menu') }}" class="btn secondary">Kembali</a>
                </div>
            </form>
        </section>
    </main>
@endsection
