<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $fillable = [
        'nama_menu',
        'kategori',
        'harga',
        'gambar',
    ];

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
