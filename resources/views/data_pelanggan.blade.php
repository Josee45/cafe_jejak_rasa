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
                    <strong>{{ $pelanggans->count() }}</strong>
                </section>
                <section class="panel mini-stat">
                    <span>Total Pesanan</span>
                    <strong>{{ $pelanggans->sum('pesanan_count') }}</strong>
                </section>
                <section class="panel mini-stat">
                    <span>Total Belanja</span>
                    <strong>Rp {{ number_format($pelanggans->sum('total_belanja'), 0, ',', '.') }}</strong>
                </section>
            </div>

            <section class="data-panel">
                <div class="data-toolbar">
                    <div>
                        <p class="eyebrow">Tabel pelanggan</p>
                        <h3>Pengguna Pelanggan</h3>
                    </div>
                    <label class="table-search">
                        <span>Cari pelanggan</span>
                        <input id="pelangganSearch" type="search" placeholder="Nama atau email">
                    </label>
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
                                    <td><strong>{{ $loop->iteration }}</strong></td>
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
        </div>
    </main>

    <script>
        const pelangganSearch = document.getElementById('pelangganSearch');
        const pelangganRows = Array.from(document.querySelectorAll('#pelangganTable tbody tr'));

        pelangganSearch?.addEventListener('input', function () {
            const keyword = this.value.trim().toLowerCase();

            pelangganRows.forEach((row) => {
                row.hidden = keyword !== '' && !row.textContent.toLowerCase().includes(keyword);
            });
        });
    </script>
@endsection
