@extends('layouts.cafe')

@section('title', 'Data Pelanggan - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <div class="container">
            <div class="page-head">
                <div>
                    <p class="eyebrow">Admin</p>
                    <h2>Data Pelanggan</h2>
                    <p>Daftar akun pelanggan yang dapat digunakan untuk memantau aktivitas pemesanan.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="btn secondary">Dashboard</a>
            </div>

            <div class="grid customer-stat-grid">
                <section class="panel mini-stat">
                    <span>Total Pelanggan</span>
                    <strong>{{ $totalPelanggan }}</strong>
                </section>
                <section class="panel mini-stat">
                    <span>Total Pesanan</span>
                    <strong>{{ $totalPesanan }}</strong>
                </section>
                <section class="panel mini-stat">
                    <span>Total Belanja</span>
                    <strong>Rp {{ number_format($totalBelanja, 0, ',', '.') }}</strong>
                </section>
            </div>

            <form method="GET" action="{{ route('data.pelanggan') }}" class="filter-form">
                <input type="search" name="q" value="{{ request('q') }}" placeholder="Cari nama atau email pelanggan">
                <button class="btn" type="submit">Filter</button>
                <a class="btn secondary" href="{{ route('data.pelanggan') }}">Reset</a>
            </form>

            <section class="data-panel">
                <div class="data-toolbar">
                    <div>
                        <p class="eyebrow">Tabel pelanggan</p>
                        <h3>Pengguna Pelanggan</h3>
                    </div>
                </div>

                <div class="table-wrap">
                    <table class="data-table" id="pelangganTable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Pelanggan</th>
                                <th>Email</th>
                                <th>Pesanan</th>
                                <th>Total Belanja</th>
                                <th>Bergabung</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($pelanggans as $pelanggan)
                                <tr>
                                    <td><strong>{{ $pelanggans->firstItem() + $loop->index }}</strong></td>
                                    <td>
                                        <div class="customer-cell">
                                            <span>{{ strtoupper(substr($pelanggan->name, 0, 1)) }}</span>
                                            <strong>{{ $pelanggan->name }}</strong>
                                        </div>
                                    </td>
                                    <td>{{ $pelanggan->email }}</td>
                                    <td>
                                        <span class="badge {{ $pelanggan->pesanan_count > 0 ? 'ok' : '' }}">
                                            {{ $pelanggan->pesanan_count }} pesanan
                                        </span>
                                    </td>
                                    <td>Rp {{ number_format($pelanggan->total_belanja ?? 0, 0, ',', '.') }}</td>
                                    <td class="muted">{{ $pelanggan->created_at->format('d M Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="muted" style="text-align:center; padding:26px;">Belum ada pelanggan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>

            @if($pelanggans->hasPages())
                <div class="simple-pagination">
                    <a class="btn secondary compact {{ $pelanggans->onFirstPage() ? 'disabled' : '' }}" @if(! $pelanggans->onFirstPage()) href="{{ $pelanggans->previousPageUrl() }}" @endif>Sebelumnya</a>
                    <span>Halaman {{ $pelanggans->currentPage() }} dari {{ $pelanggans->lastPage() }}</span>
                    <a class="btn secondary compact {{ $pelanggans->hasMorePages() ? '' : 'disabled' }}" @if($pelanggans->hasMorePages()) href="{{ $pelanggans->nextPageUrl() }}" @endif>Berikutnya</a>
                </div>
            @endif
        </div>
    </main>
@endsection
