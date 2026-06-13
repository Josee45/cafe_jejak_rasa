@extends('layouts.cafe')

@section('title', 'Daftar Pelanggan - Cafe Jejak Rasa')

@section('content')
    <main class="auth-page auth-page-customer">
        <section class="auth-intro">
            <p class="eyebrow">Pelanggan baru</p>
            <h1>Buat akun dan mulai pesan lebih cepat.</h1>
            <p>Gunakan email kamu sendiri untuk masuk, memilih menu, memproses pesanan, dan mengunduh struk.</p>
        </section>

        <section class="panel auth-card">
            <p class="eyebrow">Daftar pelanggan</p>
            <h2>Buat Akun</h2>
            <p class="muted" style="line-height:1.6;">Isi data di bawah ini untuk membuat akun pelanggan baru.</p>

            <div style="margin-top:20px;">
                @include('partials.alerts')
            </div>

            <form method="POST" action="{{ route('pelanggan.register.post') }}">
                @csrf

                <div class="field">
                    <label for="name">Nama</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus>
                </div>

                <div class="field">
                    <label for="email">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required>
                </div>

                <div class="field">
                    <label for="password">Password</label>
                    <input id="password" type="password" name="password" required>
                </div>

                <div class="field">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required>
                </div>

                <button type="submit" class="btn full">Daftar dan Masuk</button>
            </form>

            <div class="auth-switch">
                <span>Sudah punya akun?</span>
                <a href="{{ route('pelanggan.login') }}">Login Pelanggan</a>
            </div>
        </section>
    </main>
@endsection
