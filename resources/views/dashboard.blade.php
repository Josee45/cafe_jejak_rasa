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

            <div class="grid stat-grid dashboard-grid">
                <section class="panel dashboard-card">
                    <p class="eyebrow">Katalog</p>
                    <h3>Data Menu</h3>
                    <p class="muted" style="line-height:1.6;">Tambah, ubah, dan rapikan daftar menu cafe.</p>
                    <a class="btn dashboard-action" href="{{ route('data.menu') }}">Buka Menu</a>
                </section>

                <section class="panel dashboard-card">
                    <p class="eyebrow">Transaksi</p>
                    <h3>Data Pesanan</h3>
                    <p class="muted" style="line-height:1.6;">Lihat riwayat pesanan dan detail item pelanggan.</p>
                    <a class="btn dashboard-action" href="{{ route('data.pesanan') }}">Buka Pesanan</a>
                </section>

                <section class="panel dashboard-card">
                    <p class="eyebrow">Pelanggan</p>
                    <h3>Data Pelanggan</h3>
                    <p class="muted" style="line-height:1.6;">Pantau akun pelanggan, jumlah pesanan, dan total belanja.</p>
                    <a class="btn dashboard-action" href="{{ route('data.pelanggan') }}">Buka Pelanggan</a>
                </section>

                <section class="panel dashboard-card">
                    <p class="eyebrow">Aksi cepat</p>
                    <h3>Tambah Menu</h3>
                    <p class="muted" style="line-height:1.6;">Masukkan menu baru beserta kategori, harga, dan gambar.</p>
                    <a class="btn secondary dashboard-action" href="{{ route('menu.create') }}">Tambah Baru</a>
                </section>
            </div>
        </div>
    </main>
@endsection
