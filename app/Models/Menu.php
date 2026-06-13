<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    public const CATEGORY_OPTIONS = [
        'Coffee' => 'Coffee',
        'Non Coffee' => 'Non-Coffee',
        'Cemilan' => 'Snack',
    ];

    protected $fillable = [
        'nama_menu',
        'kategori',
        'harga',
        'gambar',
        'tersedia',
        'stok',
    ];

    protected function casts(): array
    {
        return [
            'harga' => 'integer',
            'tersedia' => 'boolean',
            'stok' => 'integer',
        ];
    }

    public static function categoryOptions(bool $includeAll = false): array
    {
        if ($includeAll) {
            return ['semua' => 'Semua'] + self::CATEGORY_OPTIONS;
        }

        return self::CATEGORY_OPTIONS;
    }

    public static function normalizeCategory(?string $kategori): string
    {
        $kategori = trim((string) $kategori);

        $aliases = [
            'semua' => 'semua',
            'Coffee' => 'Coffee',
            'Coffe' => 'Coffee',
            'Non Coffee' => 'Non Coffee',
            'Non-Coffee' => 'Non Coffee',
            'Non-Coffe' => 'Non Coffee',
            'Cemilan' => 'Cemilan',
            'Snack' => 'Cemilan',
        ];

        return $aliases[$kategori] ?? 'semua';
    }

    public function getKategoriLabelAttribute(): string
    {
        return self::CATEGORY_OPTIONS[$this->kategori] ?? ($this->kategori ?: 'Menu Cafe');
    }

    public function isAvailableForOrder(int $qty = 1): bool
    {
        $isMarkedAvailable = array_key_exists('tersedia', $this->attributes)
            ? (bool) $this->attributes['tersedia']
            : true;

        if (! $isMarkedAvailable) {
            return false;
        }

        return $this->stok === null || $this->stok >= $qty;
    }

    public function getAvailabilityLabelAttribute(): string
    {
        if (! $this->isAvailableForOrder()) {
            return 'Habis';
        }

        return $this->stok === null ? 'Tersedia' : 'Stok ' . $this->stok;
    }

    public function getAvailabilityBadgeClassAttribute(): string
    {
        return $this->isAvailableForOrder() ? 'ok' : 'warn';
    }

    public function getImageUrlAttribute(): string
    {
        if (! $this->gambar) {
            return asset('images/1779141246.png');
        }

        if (file_exists(public_path('images/menu/' . $this->gambar))) {
            return asset('images/menu/' . $this->gambar);
        }

        return asset('images/' . $this->gambar);
    }
}
