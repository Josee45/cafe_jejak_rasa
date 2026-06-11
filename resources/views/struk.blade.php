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
                    <span class="badge ok">{{ ucfirst($pesanan->status) }}</span>
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

            <div class="actions" style="margin-top:22px;">
                <a class="btn" href="{{ route('menu.index') }}">Kembali ke Menu</a>
                @auth('web')
                    <a class="btn secondary" href="{{ route('data.pesanan') }}">Data Pesanan</a>
                @endauth
            </div>
        </section>
    </main>
@endsection
