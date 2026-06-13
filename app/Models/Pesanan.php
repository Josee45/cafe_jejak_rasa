<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Pesanan extends Model
{
    use HasFactory;

    public const STATUS_OPTIONS = [
        'pending' => 'Pending',
        'diproses' => 'Diproses',
        'selesai' => 'Selesai',
        'dibatalkan' => 'Dibatalkan',
    ];

    public const PAYMENT_STATUS_OPTIONS = [
        'belum_bayar' => 'Belum Bayar',
        'menunggu_konfirmasi' => 'Menunggu Konfirmasi',
        'lunas' => 'Lunas',
    ];

    public const PAYMENT_METHOD_OPTIONS = [
        'tunai' => 'Tunai',
        'qris' => 'QRIS',
        'transfer' => 'Transfer',
        'ewallet' => 'E-Wallet',
    ];

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

    public function getStatusLabelAttribute(): string
    {
        return self::STATUS_OPTIONS[$this->status] ?? ucfirst((string) $this->status);
    }

    public function getStatusBadgeClassAttribute(): string
    {
        return match ($this->status) {
            'selesai' => 'ok',
            'dibatalkan' => 'danger',
            'diproses' => 'alt',
            default => 'warn',
        };
    }

    public function getPaymentStatusLabelAttribute(): string
    {
        return self::PAYMENT_STATUS_OPTIONS[$this->status_pembayaran] ?? 'Belum Bayar';
    }

    public function getPaymentBadgeClassAttribute(): string
    {
        return match ($this->status_pembayaran) {
            'lunas' => 'ok',
            'menunggu_konfirmasi' => 'alt',
            default => 'warn',
        };
    }

    public function getPaymentMethodLabelAttribute(): string
    {
        return self::PAYMENT_METHOD_OPTIONS[$this->metode_pembayaran] ?? '-';
    }
}
