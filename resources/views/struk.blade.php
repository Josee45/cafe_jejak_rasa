@extends('layouts.cafe')

@section('title', 'Struk - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <section class="panel receipt-card">
            <p class="eyebrow">Struk pesanan</p>
            <h2>Cafe Jejak Rasa</h2>

            <div class="receipt-meta">
                <div class="meta-box">
                    <div class="muted">Nomor Pesanan</div>
                    <strong>#{{ $pesanan->id }}</strong>
                </div>
                <div class="meta-box">
                    <div class="muted">Tanggal</div>
                    <strong>{{ $pesanan->created_at->format('d M Y H:i') }}</strong>
                </div>
                <div class="meta-box">
                    <div class="muted">Pelanggan</div>
                    <strong>{{ $pesanan->pelanggan->name ?? '-' }}</strong>
                </div>
                <div class="meta-box">
                    <div class="muted">Status</div>
                    <span class="badge {{ $pesanan->status_badge_class }}">{{ $pesanan->status_label }}</span>
                </div>
                <div class="meta-box">
                    <div class="muted">Pembayaran</div>
                    <span class="badge {{ $pesanan->payment_badge_class }}">{{ $pesanan->payment_status_label }}</span>
                </div>
                <div class="meta-box">
                    <div class="muted">Metode</div>
                    <strong>{{ $pesanan->payment_method_label }}</strong>
                </div>
            </div>

            <div class="table-wrap" style="box-shadow:none;">
                <table>
                    <thead>
                        <tr>
                            <th>Menu</th>
                            <th>Qty</th>
                            <th>Harga</th>
                            <th>Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pesanan->items as $item)
                            <tr>
                                <td>{{ $item->menu->nama_menu ?? 'Menu terhapus' }}</td>
                                <td>{{ $item->qty }}</td>
                                <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="total-row">
                <span>Total</span>
                <span>Rp {{ number_format($pesanan->total_harga, 0, ',', '.') }}</span>
            </div>

            @auth('pelanggan')
                @if(auth('pelanggan')->id() === $pesanan->pelanggan_id)
                    <section class="payment-box">
                        @if($pesanan->status_pembayaran === 'lunas')
                            <p class="eyebrow">Pembayaran</p>
                            <h3>Pembayaran berhasil</h3>
                            <p class="muted">
                                Dibayar dengan {{ $pesanan->payment_method_label }}
                                pada {{ $pesanan->dibayar_pada?->format('d M Y H:i') }}.
                            </p>
                        @elseif($pesanan->status_pembayaran === 'menunggu_konfirmasi')
                            <p class="eyebrow">Pembayaran</p>
                            <h3>Menunggu konfirmasi admin</h3>
                            <p class="muted">
                                Metode pembayaran {{ $pesanan->payment_method_label }} sudah dikirim.
                                Admin akan menandai lunas setelah pembayaran diterima.
                            </p>
                        @else
                            <p class="eyebrow">Pembayaran</p>
                            <h3>Konfirmasi pembayaran</h3>
                            <p class="muted">Pilih metode pembayaran yang akan kamu gunakan. Admin akan memeriksa sebelum pesanan ditandai lunas.</p>

                            <form action="{{ route('struk.bayar', $pesanan->id) }}" method="POST" class="payment-form">
                                @csrf

                                <label class="payment-option">
                                    <input type="radio" name="metode_pembayaran" value="tunai" required>
                                    <span>
                                        <strong>Tunai</strong>
                                        <small>Bayar langsung di kasir.</small>
                                    </span>
                                </label>

                                <label class="payment-option">
                                    <input type="radio" name="metode_pembayaran" value="qris" required>
                                    <span>
                                        <strong>QRIS</strong>
                                        <small>Konfirmasi pembayaran QR cafe.</small>
                                    </span>
                                </label>

                                <label class="payment-option">
                                    <input type="radio" name="metode_pembayaran" value="transfer" required>
                                    <span>
                                        <strong>Transfer</strong>
                                        <small>Transfer ke rekening cafe.</small>
                                    </span>
                                </label>

                                <label class="payment-option">
                                    <input type="radio" name="metode_pembayaran" value="ewallet" required>
                                    <span>
                                        <strong>E-Wallet</strong>
                                        <small>Bayar dengan dompet digital.</small>
                                    </span>
                                </label>

                                <button class="btn full" type="submit">Kirim Konfirmasi</button>
                            </form>
                        @endif
                    </section>
                @endif
            @endauth

            <div class="actions" style="margin-top:22px;">
                <a class="btn" href="{{ route('struk.pdf', $pesanan->id) }}">Download PDF</a>
                <a class="btn" href="{{ route('menu.index') }}">Kembali ke Menu</a>
                @auth('web')
                    <a class="btn secondary" href="{{ route('data.pesanan') }}">Data Pesanan</a>
                @endauth
            </div>
        </section>
    </main>
@endsection
