<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\PelangganAuthController;
use App\Http\Controllers\PesananController;
use App\Http\Controllers\StrukController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PesananAdminController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use App\Models\Menu;
use App\Models\Pelanggan;

/*
|--------------------------------------------------------------------------
| Halaman utama pelanggan
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    $menus = Schema::hasTable('menus')
        ? Cache::remember('home_menu_terbaru', 60, fn () => Menu::latest()->take(6)->get())
        : collect();

    return view('home', compact('menus'));
})->name('home');

Route::get('/home', function () {
    $menus = Schema::hasTable('menus')
        ? Cache::remember('home_menu_terbaru', 60, fn () => Menu::latest()->take(6)->get())
        : collect();

    return view('home', compact('menus'));
})->name('home.page');

/*
|--------------------------------------------------------------------------
| Menu untuk pelanggan
|--------------------------------------------------------------------------
*/

Route::get('/menu', [MenuController::class, 'index'])
    ->name('menu.index');

/*
|--------------------------------------------------------------------------
| Login pelanggan
|--------------------------------------------------------------------------
*/

Route::get('/login-pelanggan', [PelangganAuthController::class, 'showLogin'])
    ->name('pelanggan.login');

Route::post('/login-pelanggan', [PelangganAuthController::class, 'login'])
    ->name('pelanggan.login.post');

Route::get('/daftar-pelanggan', [PelangganAuthController::class, 'showRegister'])
    ->name('pelanggan.register');

Route::post('/daftar-pelanggan', [PelangganAuthController::class, 'register'])
    ->name('pelanggan.register.post');

/*
|--------------------------------------------------------------------------
| Pesan pelanggan
|--------------------------------------------------------------------------
*/

Route::middleware('auth:pelanggan')->group(function () {
    Route::get('/pesan', [PesananController::class, 'showForm'])
        ->name('pelanggan.pesan');

    Route::post('/pesan/cart/add', [PesananController::class, 'addToCart'])
        ->name('pelanggan.cart.add');

    Route::post('/pesan/proses', [PesananController::class, 'proses'])
        ->name('pelanggan.pesanan.proses');

    Route::post('/struk/{id}/bayar', [StrukController::class, 'bayar'])
        ->name('struk.bayar');

    Route::post('/logout-pelanggan', [PelangganAuthController::class, 'logout'])
        ->name('pelanggan.logout');
});

/*
|--------------------------------------------------------------------------
| Struk
|--------------------------------------------------------------------------
*/

Route::get('/struk/{id}', [StrukController::class, 'show'])
    ->name('struk.show');

Route::get('/struk/{id}/pdf', [StrukController::class, 'pdf'])
    ->name('struk.pdf');

/*
|--------------------------------------------------------------------------
| Login utama dan kompatibilitas admin
|--------------------------------------------------------------------------
*/

Route::get('/login-admin', fn () => redirect()->route('pelanggan.login'))
    ->name('admin.login');

Route::post('/login-admin', [PelangganAuthController::class, 'login'])
    ->name('admin.login.post');

Route::post('/logout-admin', [\App\Http\Controllers\AdminAuthController::class, 'logout'])
    ->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Dashboard admin
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin: data menu, data pesanan, profile
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {


    Route::get('/data-menu', function () {
        $menus = Menu::latest()->get();
        return view('data_menu', compact('menus'));
    })->name('data.menu');

    Route::get('/menu/tambah', [MenuController::class, 'create'])
        ->name('menu.create');

    Route::post('/menu', [MenuController::class, 'store'])
        ->name('menu.store');

    Route::get('/menu/{id}/edit', [MenuController::class, 'edit'])
        ->name('menu.edit');

    Route::put('/menu/{id}', [MenuController::class, 'update'])
        ->name('menu.update');

    Route::delete('/menu/{id}', [MenuController::class, 'destroy'])
        ->name('menu.destroy');

    Route::get('/data-pesanan', [PesananAdminController::class, 'dataPesanan'])
        ->name('data.pesanan');

    Route::get('/data-pelanggan', function () {
        $pelanggans = Pelanggan::withCount('pesanan')
            ->withSum('pesanan as total_belanja', 'total_harga')
            ->latest()
            ->get();

        return view('data_pelanggan', compact('pelanggans'));
    })->name('data.pelanggan');

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
