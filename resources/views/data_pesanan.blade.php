@extends('layouts.cafe')

@section('title', 'Data Pesanan - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <div class="container">
            <div class="page-head">
                <div>
                    <p class="eyebrow">Admin</p>
                    <h2>Data Pesanan</h2>
                    <p>Riwayat pesanan pelanggan beserta status proses dan pembayaran.</p>
                </div>
            </div>

            @include('partials.alerts')

            <form method="GET" action="{{ route('data.pesanan') }}" class="filter-form">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nomor, pelanggan, atau menu">

                <select name="status" aria-label="Filter status pesanan">
                    <option value="">Semua Status</option>
                    @foreach($statusOptions as $value => $label)
                        <option value="{{ $value }}" @selected(request('status') === $value)>{{ $label }}</option>
                    @endforeach
                </select>

                <select name="pembayaran" aria-label="Filter status pembayaran">
                    <option value="">Semua Pembayaran</option>
                    @foreach($paymentStatusOptions as $value => $label)
                        <option value="{{ $value }}" @selected(request('pembayaran') === $value)>{{ $label }}</option>
                    @endforeach
                </select>

                <input type="date" name="tanggal" value="{{ request('tanggal') }}" aria-label="Filter tanggal">

                <button class="btn" type="submit">Filter</button>
                <a class="btn secondary" href="{{ route('data.pesanan') }}">Reset</a>
            </form>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
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
                                <td>{{ $p->pelanggan->name ?? '-' }}</td>
                                <td>
                                    @foreach($p->items as $item)
                                        <div>
                                            {{ $item->menu->nama_menu ?? 'Menu terhapus' }}
                                            <span class="muted">x {{ $item->qty }}</span>
                                        </div>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge {{ $p->status_badge_class }}">{{ $p->status_label }}</span>
                                    <form action="{{ route('data.pesanan.status', $p->id) }}" method="POST" class="compact-form">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status" aria-label="Ubah status pesanan #{{ $p->id }}">
                                            @foreach($statusOptions as $value => $label)
                                                <option value="{{ $value }}" @selected($p->status === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn secondary compact" type="submit">Simpan</button>
                                    </form>
                                </td>
                                <td>
                                    <span class="badge {{ $p->payment_badge_class }}">{{ $p->payment_status_label }}</span>
                                    @if($p->metode_pembayaran)
                                        <div class="muted" style="margin-top:6px;">{{ $p->payment_method_label }}</div>
                                    @endif
                                    <form action="{{ route('data.pesanan.pembayaran', $p->id) }}" method="POST" class="compact-form">
                                        @csrf
                                        @method('PATCH')
                                        <select name="status_pembayaran" aria-label="Ubah pembayaran pesanan #{{ $p->id }}">
                                            @foreach($paymentStatusOptions as $value => $label)
                                                <option value="{{ $value }}" @selected($p->status_pembayaran === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn secondary compact" type="submit">Simpan</button>
                                    </form>
                                </td>
                                <td>Rp {{ number_format($p->total_harga, 0, ',', '.') }}</td>
                                <td class="muted">{{ $p->created_at->format('d M Y H:i') }}</td>
                                <td><a href="{{ route('struk.show', $p->id) }}" class="btn secondary">Struk</a></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="muted" style="text-align:center; padding:26px;">Belum ada pesanan.</td>
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
