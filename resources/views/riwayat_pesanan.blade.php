@extends('layouts.cafe')

@section('title', 'Pesanan Saya - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <div class="container">
            <div class="page-head">
                <div>
                    <p class="eyebrow">Pelanggan</p>
                    <h2>Pesanan Saya</h2>
                    <p>Lihat riwayat pesanan, status proses, dan status pembayaran kamu.</p>
                </div>
                <a class="btn" href="{{ route('pelanggan.pesan') }}">Pesan Lagi</a>
            </div>

            @include('partials.alerts')

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Items</th>
                            <th>Status</th>
                            <th>Pembayaran</th>
                            <th>Total</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($pesanan as $p)
                            <tr>
                                <td><strong>#{{ $p->id }}</strong></td>
                                <td>
                                    @foreach($p->items as $item)
                                        <div>
                                            {{ $item->menu->nama_menu ?? 'Menu terhapus' }}
                                            <span class="muted">x {{ $item->qty }}</span>
                                        </div>
                                    @endforeach
                                </td>
                                <td><span class="badge {{ $p->status_badge_class }}">{{ $p->status_label }}</span></td>
                                <td>
                                    <span class="badge {{ $p->payment_badge_class }}">{{ $p->payment_status_label }}</span>
                                    @if($p->metode_pembayaran)
                                        <div class="muted" style="margin-top:6px;">{{ $p->payment_method_label }}</div>
                                    @endif
                                </td>
                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td class="muted">{{ $p->created_at->format('d M Y H:i') }}</td>
                                <td><a href="{{ route('struk.show', $p->id) }}" class="btn secondary">Struk</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="muted" style="text-align:center; padding:26px;">Belum ada pesanan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($pesanan->hasPages())
                <div class="simple-pagination">
                    <a class="btn secondary compact {{ $pesanan->onFirstPage() ? 'disabled' : '' }}" @if(! $pesanan->onFirstPage()) href="{{ $pesanan->previousPageUrl() }}" @endif>Sebelumnya</a>
                    <span>Halaman {{ $pesanan->currentPage() }} dari {{ $pesanan->lastPage() }}</span>
                    <a class="btn secondary compact {{ $pesanan->hasMorePages() ? '' : 'disabled' }}" @if($pesanan->hasMorePages()) href="{{ $pesanan->nextPageUrl() }}" @endif>Berikutnya</a>
                </div>
            @endif
        </div>
    </main>
@endsection
