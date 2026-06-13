@extends('layouts.cafe')

@section('title', 'Login - Cafe Jejak Rasa')

@section('content')
    <main class="auth-page auth-page-customer">
        <section class="auth-intro">
            <p class="eyebrow">Cafe Jejak Rasa</p>
            <h1>Masuk dan mulai aktivitasmu.</h1>
            <p>Gunakan email dan password akun kamu untuk melanjutkan ke halaman yang sesuai.</p>
        </section>

        <section class="panel auth-card">
            <p class="eyebrow">Akun</p>
            <h2>Login</h2>
            <p class="muted" style="line-height:1.6;">Masukkan email dan password untuk masuk ke Cafe Jejak Rasa.</p>

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
        </section>
    </main>
@endsection
