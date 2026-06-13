<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->string('status_pembayaran')->default('belum_bayar')->after('status');
            $table->string('metode_pembayaran')->nullable()->after('status_pembayaran');
            $table->timestamp('dibayar_pada')->nullable()->after('metode_pembayaran');
        });
    }

    public function down(): void
    {
        Schema::table('pesanan', function (Blueprint $table) {
            $table->dropColumn([
                'status_pembayaran',
                'metode_pembayaran',
                'dibayar_pada',
            ]);
        });
    }
};
