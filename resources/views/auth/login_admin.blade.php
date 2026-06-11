@extends('layouts.cafe')

@section('title', 'Login Admin - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <section class="panel auth-card">
            <p class="eyebrow">Admin</p>
            <h2>Login Admin</h2>
            <p class="muted" style="line-height:1.6;">Masuk untuk mengelola menu dan pesanan.</p>

            <div style="margin-top:20px;">
                @include('partials.alerts')
            </div>

            <form method="POST" action="{{ route('admin.login.post') }}">
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
