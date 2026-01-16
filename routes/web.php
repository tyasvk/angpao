<?php

use App\Http\Controllers\AngpaoController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\VoucherController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


/*
|--------------------------------------------------------------------------
| Halaman Publik (Tanpa Login)
|--------------------------------------------------------------------------
*/

// Halaman Masukkan Voucher (Public)
Route::get('/', function () {
    return Inertia::render('Welcome'); 
})->name('home');

// Proses Klaim Voucher
Route::post('/claim', [AngpaoController::class, 'processClaim'])->name('angpao.claim');
/*
|--------------------------------------------------------------------------
| Dashboard Admin (Wajib Login & Verifikasi)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified'])->group(function () {

    // Alias rute 'dashboard' agar tidak error saat redirect setelah login Breeze
    Route::get('/dashboard', function () {
        return redirect()->route('admin.dashboard');
    })->name('dashboard');

    // Grup Utama Admin
    Route::prefix('admin')->name('admin.')->group(function () {
        
        // Ringkasan Statistik
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Manajemen CRUD Voucher
        Route::controller(VoucherController::class)->group(function () {
            Route::get('/vouchers', 'index')->name('vouchers.index');
            Route::post('/vouchers', 'store')->name('vouchers.store');
            Route::put('/vouchers/{voucher}', 'update')->name('vouchers.update');
            Route::delete('/vouchers/{voucher}', 'destroy')->name('vouchers.destroy');
        });

        // Pengaturan Profil Admin
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

        Route::get('/dashboard', [AngpaoController::class, 'index'])->name('dashboard');
        Route::get('/angpao/history', [AngpaoController::class, 'history'])->name('angpao.history');

        // Rute Manajemen Angpao
        Route::get('/angpao/create', [AngpaoController::class, 'create'])->name('angpao.create');
        Route::post('/angpao', [AngpaoController::class, 'store'])->name('angpao.store');
        Route::get('/angpao', [AngpaoController::class, 'index'])->name('angpao.index'); // Untuk halaman list

        Route::get('/angpao', [AngpaoController::class, 'index_master'])->name('angpao.index');

        Route::delete('/angpao/batch', [AngpaoController::class, 'destroyBatch'])->name('angpao.destroyBatch');
    Route::delete('/angpao/{angpao}', [AngpaoController::class, 'destroy'])->name('angpao.destroy');

    });
});

/*
|--------------------------------------------------------------------------
| Rute Autentikasi (Breeze)
|--------------------------------------------------------------------------
| Rute login, logout, register, dan reset password dikelola oleh file ini.
*/
require __DIR__.'/auth.php';