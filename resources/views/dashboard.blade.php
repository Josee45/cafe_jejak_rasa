@extends('layouts.cafe')

@section('title', 'Dashboard - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <div class="container">
            <div class="page-head">
                <div>
                    <p class="eyebrow">Admin</p>
                    <h2>Dashboard</h2>
                    <p>Kelola menu dan pantau pesanan pelanggan dari satu tempat.</p>
                </div>
            </div>

            <div class="grid stat-grid">
                <section class="panel">
                    <p class="eyebrow">Katalog</p>
                    <h3>Data Menu</h3>
                    <p class="muted" style="line-height:1.6;">Tambah, ubah, dan rapikan daftar menu cafe.</p>
                    <a class="btn" href="{{ route('data.menu') }}" style="margin-top:14px;">Buka Menu</a>
                </section>

                <section class="panel">
                    <p class="eyebrow">Transaksi</p>
                    <h3>Data Pesanan</h3>
                    <p class="muted" style="line-height:1.6;">Lihat riwayat pesanan dan detail item pelanggan.</p>
                    <a class="btn" href="{{ route('data.pesanan') }}" style="margin-top:14px;">Buka Pesanan</a>
                </section>

                <section class="panel">
                    <p class="eyebrow">Pelanggan</p>
                    <h3>Data Pelanggan</h3>
                    <p class="muted" style="line-height:1.6;">Pantau akun pelanggan, jumlah pesanan, dan total belanja.</p>
                    <a class="btn" href="{{ route('data.pelanggan') }}" style="margin-top:14px;">Buka Pelanggan</a>
                </section>

                <section class="panel">
                    <p class="eyebrow">Aksi cepat</p>
                    <h3>Tambah Menu</h3>
                    <p class="muted" style="line-height:1.6;">Masukkan menu baru beserta kategori, harga, dan gambar.</p>
                    <a class="btn secondary" href="{{ route('menu.create') }}" style="margin-top:14px;">Tambah Baru</a>
                </section>
            </div>
        </div>
    </main>
@endsection
