<?php

namespace App\Http\Controllers;

use App\Models\Pesanan;
use Illuminate\Support\Facades\Auth;

class StrukController extends Controller
{
    public function show($id)
    {
        $pesanan = Pesanan::with(['pelanggan', 'items.menu'])->findOrFail($id);

        // jika ingin pembatasan pelanggan, uncomment:
        // $pelanggan = Auth::guard('pelanggan')->user();
        // abort_unless($pesanan->pelanggan_id === $pelanggan->id, 403);

        return view('struk', compact('pesanan'));
    }
}

