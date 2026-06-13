@extends('layouts.cafe')

@section('title', 'Menu - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <div class="container">
            <div class="page-head">
                <div>
                    <p class="eyebrow">Daftar menu</p>
                    <h2>Menu Cafe Jejak Rasa</h2>
                    <p>Pilih kategori untuk menemukan minuman atau camilan yang sedang kamu cari.</p>
                </div>
            </div>

            @include('partials.alerts')

            <div class="filter-bar">
                @foreach($categoryOptions as $value => $label)
                    <a
                        href="{{ route('menu.index', ['kategori' => $value]) }}"
                        class="filter-pill {{ ($kategori ?? 'semua') === $value || (!$kategori && $value === 'semua') ? 'active' : '' }}"
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <div class="grid menu-grid">
                @forelse($menus as $menu)
                    @include('partials.menu-card', ['menu' => $menu])
                @empty
                    <div class="empty">Belum ada data menu.</div>
                @endforelse
            </div>
        </div>
    </main>
@endsection
