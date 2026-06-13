@extends('layouts.cafe')

@section('title', 'Login Pelanggan - Cafe Jejak Rasa')

@section('content')
    <main class="auth-page auth-page-customer">
        <section class="auth-intro">
            <p class="eyebrow">Pelanggan</p>
            <h1>Masuk dan pilih menu favoritmu.</h1>
            <p>Pesan coffee, non-coffee, dan snack dengan alur yang lebih cepat dari meja kamu.</p>
        </section>

        <section class="panel auth-card">
            <p class="eyebrow">Akun pelanggan</p>
            <h2>Login Pelanggan</h2>
            <p class="muted" style="line-height:1.6;">Gunakan akun pelanggan untuk membuat pesanan dan melihat struk.</p>

            <div style="margin-top:20px;">
                @include('partials.alerts')
            </div>

            <form method="POST" action="{{ route('pelanggan.login.post') }}">
                @csrf

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <button type="submit" class="btn full">Login</button>
            </form>

            <div class="auth-switch">
                <span>Belum punya akun?</span>
                <a href="{{ route('pelanggan.register') }}">Daftar Pelanggan</a>
            </div>

            <div class="auth-switch compact">
                <span>Masuk sebagai admin?</span>
                <a href="{{ route('admin.login') }}">Login Admin</a>
            </div>
        </section>
    </main>
@endsection
