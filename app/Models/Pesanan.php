<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    protected $table = 'pesanan';

    protected $fillable = [
        'pelanggan_id',
        'status',
        'status_pembayaran',
        'metode_pembayaran',
        'dibayar_pada',
        'total_harga',
    ];

    protected function casts(): array
    {
        return [
            'dibayar_pada' => 'datetime',
        ];
    }

    public function pelanggan()
    {
        return $this->belongsTo(Pelanggan::class, 'pelanggan_id');
    }

    public function items()
    {
        return $this->hasMany(PesananItem::class, 'pesanan_id');
    }
}

