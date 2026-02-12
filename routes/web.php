<?php

use App\Http\Controllers\GuestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HumasController;
use App\Http\Controllers\SuperAdminController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Guest
Route::get('/', [GuestController::class, 'index'])->name('home');
Route::get('/daftar-memori-telepon', [GuestController::class, 'daftarMemoriTelepon'])->name('daftar-memori-telepon');

Route::get('/mlebu', [AuthController::class, 'login'])->name('login');
Route::post('/process-login', [AuthController::class, 'authenticate'])->name('authenticate');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Panel User Admin
Route::prefix('panel')->group(function () {
    Route::get('/extension', [HomeController::class, 'index'])->name('admin.extension');
    Route::get('/export-ext-adm', [GuestController::class, 'exportpdf'])->name('export');
    Route::post('/extension/store', [HomeController::class, 'storeExtension'])->name('store.extension');
    Route::get('/extension/{id}/edit', [HomeController::class, 'editExtension'])->name('edit.extension');
    Route::post('/extension/{id}/update', [HomeController::class, 'updateExtension'])->name('update.extension');
    Route::get('/extension/{id}/destroy', [HomeController::class, 'destroyExtension'])->name('destroy.extension');
});

// Panel User Humas
Route::prefix('panel')->group(function () {
    Route::get('/humas-extension-hm', [HumasController::class, 'index'])->name('humas.extension');
    Route::get('/humas-dokter', [HumasController::class, 'dokter'])->name('humas.dokter');
    Route::post('/dokter/store', [HumasController::class, 'storeDokter'])->name('store.dokter');
    Route::get('/dokter/{id}/edit', [HumasController::class, 'editDokter'])->name('edit.dokter');
    Route::post('/dokter/{id}/update', [HumasController::class, 'updateDokter'])->name('update.dokter');
    Route::get('/dokter/{id}/destroy', [HumasController::class, 'destroyDokter'])->name('destroy.dokter');

    // export
    Route::get('/export-ext', [GuestController::class, 'exportpdf'])->name('export-humas');
    Route::get('/export-dr', [GuestController::class, 'exportpdf3'])->name('export.dokter');
});

Route::prefix('panel-super-admin')->group((function () {
    Route::get('/memori', [SuperAdminController::class, 'index'])->name('super_admin.extension');
    Route::post('/store-memori', [SuperAdminController::class, 'storeMemori'])->name('super_admin.memori');
    Route::get('/memori/{id}/edit', [SuperAdminController::class, 'editExtension'])->name('super_admin.edit');
    Route::post('/memori/{id}/update', [SuperAdminController::class, 'updateExtension'])->name('super_admin.update.memori');
    Route::get('/memori/{id}/destroy', [SuperAdminController::class, 'destroyExtension'])->name('super_admin.delete.memori');
    Route::get('/export-memori/by-super-admin', [GuestController::class, 'exportpdf2'])->name('export-memori');

    //dokter
    Route::get('/humas-dokter', [HumasController::class, 'dokter'])->name('humas.dokter');
    Route::post('/dokter-adm/store', [HumasController::class, 'storeDokter'])->name('store.dokter');
    Route::get('/dokter/{id}/edit', [HumasController::class, 'editDokter'])->name('edit.dokter');
    Route::post('/dokter/{id}/update', [HumasController::class, 'updateDokter'])->name('update.dokter');
    Route::get('/dokter/{id}/destroy', [HumasController::class, 'destroyDokter'])->name('destroy.dokter');

    // export
    Route::get('/export-ext', [GuestController::class, 'exportpdf'])->name('export-humas');
    Route::get('/export-dr', [GuestController::class, 'exportpdf3'])->name('export.dokter');

    //ext
    Route::get('/extension', [HomeController::class, 'index'])->name('admin.extension');
    Route::get('/export-ext-adm', [GuestController::class, 'exportpdf'])->name('export');
    Route::post('/extension/store', [HomeController::class, 'storeExtension'])->name('store.extension');
    Route::get('/extension/{id}/edit', [HomeController::class, 'editExtension'])->name('edit.extension');
    Route::post('/extension/{id}/update', [HomeController::class, 'updateExtension'])->name('update.extension');
    Route::get('/extension/{id}/destroy', [HomeController::class, 'destroyExtension'])->name('destroy.extension');
}));

// 🔴 ROUTE SEMENTARA UNTUK RESET PASSWORD – HAPUS SETELAH BERHASIL LOGIN 🔴
Route::get('/reset-password-manual', function () {
    // Ganti 'super_admin' dengan name user yang mau dipakai login
    $user = User::where('name', 'agung')->first();

    if (! $user) {
        return 'User dengan name "super_admin" tidak ditemukan.';
    }

    // Ganti 'admin123' dengan password baru yang kamu mau
    $user->password = Hash::make('414449');
    $user->save();

    return 'Password super_admin berhasil direset. Silakan login dengan password: admin123';
});
