<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Khusus Siswa
    Route::middleware(['role:siswa'])->group(function () {
        Route::get('/pinjam/ajukan', [BorrowingController::class, 'create'])->name('borrowing.create');
        Route::post('/pinjam/store', [BorrowingController::class, 'store'])->name('borrowing.store');
        Route::get('/riwayat', [BorrowingController::class, 'history'])->name('borrowing.history');
        Route::post('/borrowing/{id}/cancel', [BorrowingController::class, 'cancel'])->name('borrowing.cancel');
    });

    // Khusus Petugas
Route::middleware(['role:petugas'])->group(function () {
    Route::resource('inventaris', InventoryController::class);
    Route::get('/peminjaman', [BorrowingController::class, 'index'])->name('borrowing.index');
    Route::post('/borrowing/{id}/approve', [BorrowingController::class, 'approve'])->name('borrowing.approve');
    Route::post('/borrowing/{id}/reject', [BorrowingController::class, 'reject'])->name('borrowing.reject');
    Route::post('/borrowing/{id}/return', [BorrowingController::class, 'returnItem'])->name('borrowing.return');
    Route::get('/laporan', [BorrowingController::class, 'report'])->name('borrowing.report');
});
});

require __DIR__.'/auth.php';