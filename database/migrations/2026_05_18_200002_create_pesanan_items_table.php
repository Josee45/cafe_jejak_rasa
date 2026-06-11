<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pesanan_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pesanan_id')->constrained('pesanan')->cascadeOnDelete();
            $table->foreignId('menu_id')->constrained('menus')->cascadeOnDelete();
            $table->unsignedInteger('qty')->default(1);
            $table->decimal('harga_satuan', 12, 2);
            $table->decimal('subtotal', 12, 2);
            $table->timestamps();

            $table->unique(['pesanan_id', 'menu_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pesanan_items');
    }
};

