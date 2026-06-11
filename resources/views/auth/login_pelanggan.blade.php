@extends('layouts.cafe')

@section('title', 'Login Pelanggan - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <section class="panel auth-card">
            <p class="eyebrow">Pelanggan</p>
            <h2>Login Pelanggan</h2>
            <p class="muted" style="line-height:1.6;">Masuk untuk mulai membuat pesanan.</p>

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
