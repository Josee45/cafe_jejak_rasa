@extends('layouts.cafe')

@section('title', 'Pesan - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <div class="container">
            <div class="page-head">
                <div>
                    <p class="eyebrow">Pemesanan</p>
                    <h2>Pilih menu dan jumlahnya</h2>
                    <p>Tambahkan beberapa menu ke keranjang, lalu proses pesanan saat sudah siap.</p>
                </div>
            </div>

            @include('partials.alerts')

            <div class="filter-bar">
                @foreach($categoryOptions as $value => $label)
                    <a
                        href="{{ route('pelanggan.pesan', ['kategori' => $value]) }}"
                        class="filter-pill {{ ($kategori ?? 'semua') === $value || (!$kategori && $value === 'semua') ? 'active' : '' }}"
                    >
                        {{ $label }}
                    </a>
                @endforeach
            </div>

            <div class="cart-layout">
                <div class="grid menu-grid">
                    @forelse($menus as $menu)
                        @include('partials.menu-card', ['menu' => $menu, 'orderable' => true])
                    @empty
                        <div class="empty">Belum ada menu tersedia.</div>
                    @endforelse
                </div>

                <aside class="panel">
                    <p class="eyebrow">Keranjang</p>
                    <h3>Pesanan kamu</h3>

                    @if($cartItems->isEmpty())
                        <p class="muted" style="line-height:1.6;">Keranjang masih kosong.</p>
                    @else
                        <ul class="cart-list">
                            @foreach($cartItems as $item)
                                <li class="cart-item">
                                    <div>
                                        <strong>{{ $item['menu']->nama_menu }}</strong>
                                        <div class="muted">{{ $item['qty'] }} x Rp {{ number_format($item['menu']->harga, 0, ',', '.') }}</div>
                                        <form action="{{ route('pelanggan.cart.update', $item['menu']->id) }}" method="POST" class="cart-update-form">
                                            @csrf
                                            @method('PATCH')
                                            <input type="number" name="qty" value="{{ $item['qty'] }}" min="0" @if($item['menu']->stok !== null) max="{{ $item['menu']->stok }}" @endif aria-label="Ubah jumlah {{ $item['menu']->nama_menu }}">
                                            <button class="btn secondary compact" type="submit">Update</button>
                                        </form>
                                    </div>
                                    <div class="cart-price-actions">
                                        <strong>Rp {{ number_format($item['subtotal'], 0, ',', '.') }}</strong>
                                        <form action="{{ route('pelanggan.cart.remove', $item['menu']->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn danger compact" type="submit">Hapus</button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>

                        <div class="total-row">
                            <span>Total</span>
                            <span>Rp {{ number_format($cartTotal, 0, ',', '.') }}</span>
                        </div>

                        <form action="{{ route('pelanggan.pesanan.proses') }}" method="POST" style="margin-top:18px;">
                            @csrf
                            <button class="btn full" type="submit">Proses Pesanan</button>
                        </form>

                        <form action="{{ route('pelanggan.cart.clear') }}" method="POST" style="margin-top:10px;">
                            @csrf
                            @method('DELETE')
                            <button class="btn secondary full" type="submit">Kosongkan Keranjang</button>
                        </form>
                    @endif
                </aside>
            </div>
        </div>
    </main>
@endsection
