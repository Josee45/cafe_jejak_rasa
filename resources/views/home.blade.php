@extends('layouts.cafe')

@section('title', 'Home - Cafe Jejak Rasa')

@section('content')
    @if(auth('pelanggan')->guest() && auth('web')->guest())
        <main class="splash-page">
            <section class="splash-hero">
                <div class="splash-copy">
                    <p class="eyebrow">Cafe Jejak Rasa</p>
                    <h1>Pesan menu favorit dari meja kamu.</h1>
                    <p>Mulai dari coffee, non coffee, sampai cemilan hangat. Masuk sebagai pelanggan untuk memilih menu dan mendapatkan struk pesanan.</p>

                    <div class="actions">
                        <a href="{{ route('pelanggan.login') }}" class="btn">Mulai Pesan</a>
                        <a href="{{ route('admin.login') }}" class="btn secondary">Login Admin</a>
                    </div>
                </div>

                <div class="splash-menu-preview">
                    <img src="{{ asset('images/menu/caramel_machiatto.png') }}" alt="Caramel macchiato">
                    <div>
                        <span>Rekomendasi hari ini</span>
                        <strong>Caramel Macchiato</strong>
                        <small>Minuman manis lembut untuk menemani waktu santai.</small>
                    </div>
                </div>
            </section>
        </main>
    @else
        <section class="hero">
            <div class="hero-content">
                <p class="eyebrow">Coffee, non coffee, dan cemilan</p>
                <h1>Cafe Jejak Rasa</h1>
                @auth('pelanggan')
                    <p class="customer-note">Selamat datang, {{ auth('pelanggan')->user()->name }}.</p>
                    <p class="lead">Pilih menu favoritmu, tambahkan ke keranjang, lalu proses pesanan dengan cepat.</p>
                @else
                    <p class="lead">Tempat singgah untuk menu hangat, minuman segar, dan camilan yang siap menemani waktu santai.</p>
                @endauth
                <div class="actions" style="margin-top:26px;">
                    @auth('pelanggan')
                        <a href="{{ route('pelanggan.pesan') }}" class="btn">Pesan Sekarang</a>
                        <a href="{{ route('menu.index') }}" class="btn light">Lihat Menu</a>
                    @else
                        <a href="{{ route('menu.index') }}" class="btn">Lihat Menu</a>
                        <a href="{{ route('pelanggan.login') }}" class="btn secondary">Login Pelanggan</a>
                    @endauth
                </div>
            </div>
        </section>

        <main class="page">
            <div class="container">
                <div class="section-head">
                    <div>
                        <p class="eyebrow">Menu terbaru</p>
                        <h2>Pilihan favorit hari ini</h2>
                        <p>Beberapa menu terbaru dari dapur dan bar kami.</p>
                    </div>
                    <a href="{{ route('menu.index') }}" class="btn secondary">Semua Menu</a>
                </div>

                <div class="grid menu-grid">
                    @forelse($menus as $menu)
                        @include('partials.menu-card', ['menu' => $menu])
                    @empty
                        <div class="empty">Belum ada menu yang ditambahkan.</div>
                    @endforelse
                </div>
            </div>
        </main>
    @endif
@endsection
