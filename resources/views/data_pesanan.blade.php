@extends('layouts.cafe')

@section('title', 'Data Pesanan - Cafe Jejak Rasa')

@section('content')
    <main class="page">
        <div class="container">
            <div class="page-head">
                <div>
                    <p class="eyebrow">Admin</p>
                    <h2>Data Pesanan</h2>
                    <p>Riwayat pesanan pelanggan beserta detail item.</p>
                </div>
            </div>

            <div class="table-wrap">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Pelanggan</th>
                            <th>Items</th>
                            <th>Status</th>
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
                                <td><span class="badge ok">{{ ucfirst($p->status) }}</span></td>
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
        </div>
    </main>
@endsection
