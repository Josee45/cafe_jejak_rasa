<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;

class PesananAdminController extends Controller
{
    public function dataPesanan()
    {
        $pesanan = Pesanan::with(['pelanggan', 'items.menu'])
            ->latest()
            ->get();

        return view('data_pesanan', compact('pesanan'));
    }
}

