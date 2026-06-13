@extends('layouts.cafe')

@section('title', 'Home - Cafe Jejak Rasa')

@section('content')
    @if(auth('pelanggan')->guest() && auth('web')->guest())
        <main class="splash-page">
            <section class="splash-hero">
                <div class="splash-copy">
                    <p class="eyebrow">Cafe Jejak Rasa</p>
                    <h1>Pesan menu favorit dari meja kamu.</h1>
                    <p>Mulai dari coffee, non-coffee, sampai snack hangat. Masuk sebagai pelanggan untuk memilih menu dan mendapatkan struk pesanan.</p>

                    <div class="actions">
                        <a href="{{ route('pelanggan.login') }}" class="btn">Mulai Pesan</a>
                        <a href="{{ route('pelanggan.register') }}" class="btn secondary">Daftar Pelanggan</a>
                    </div>
                </div>

                <div class="splash-visual">
                    <article class="splash-feature-card">
                        <img src="{{ asset('images/menu/caramel_machiatto.png') }}" alt="Caramel macchiato">
                        <div>
                            <span>Rekomendasi hari ini</span>
                            <strong>Caramel Macchiato</strong>
                            <small>Minuman manis lembut untuk menemani waktu santai.</small>
                        </div>
                    </article>

                    <div class="splash-stack">
                        <article class="splash-mini-card">
                            <img src="{{ asset('images/menu/croissant.png') }}" alt="Croissant">
                            <div>
                                <strong>Croissant</strong>
                                <small>Fresh pastry</small>
                            </div>
                        </article>

                        <article class="splash-mini-card">
                            <img src="{{ asset('images/menu/matcha_latte.png') }}" alt="Matcha latte">
                            <div>
                                <strong>Matcha Latte</strong>
                                <small>Non coffee</small>
                            </div>
                        </article>

                        <article class="splash-mini-card">
                            <img src="{{ asset('images/menu/burger.png') }}" alt="Burger">
                            <div>
                                <strong>Burger</strong>
                                <small>Snack favorit</small>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </main>
    @else
        <section class="hero">
            <div class="hero-content">
                <p class="eyebrow">Coffee, Non-Coffee, dan Snack</p>
                <h1>Cafe Jejak Rasa</h1>
                @if(auth('pelanggan')->check())
                    <p class="customer-note">Selamat datang, {{ auth('pelanggan')->user()->name }}.</p>
                    <p class="lead">Pilih menu favoritmu, tambahkan ke keranjang, lalu proses pesanan dengan cepat.</p>
                @elseif(auth('web')->check())
                    <p class="customer-note">Mode admin aktif.</p>
                    <p class="lead">Kelola menu, pesanan, dan data pelanggan dari dashboard cafe.</p>
                @else
                    <p class="lead">Tempat singgah untuk menu hangat, minuman segar, dan camilan yang siap menemani waktu santai.</p>
                @endif
                <div class="actions" style="margin-top:26px;">
                    @if(auth('pelanggan')->check())
                        <a href="{{ route('pelanggan.pesan') }}" class="btn">Pesan Sekarang</a>
                        <a href="{{ route('menu.index') }}" class="btn light">Lihat Menu</a>
                    @elseif(auth('web')->check())
                        <a href="{{ route('dashboard') }}" class="btn">Dashboard</a>
                        <a href="{{ route('data.menu') }}" class="btn light">Data Menu</a>
                    @else
                        <a href="{{ route('menu.index') }}" class="btn">Lihat Menu</a>
                        <a href="{{ route('pelanggan.login') }}" class="btn secondary">Login</a>
                    @endif
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
