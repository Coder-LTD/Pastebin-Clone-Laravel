<?php

use App\Http\Controllers\PasteController;
use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Support\Facades\Route;

// Admin routes (must be before wildcard /{slug})
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login', [DashboardController::class, 'loginForm'])->name('login');
    Route::post('/login', [DashboardController::class, 'login'])->name('login.submit');
    Route::post('/logout', [DashboardController::class, 'logout'])->name('logout');

    Route::middleware('admin')->group(function () {
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::delete('/pastes/{slug}', [DashboardController::class, 'destroy'])->name('pastes.destroy');
        Route::post('/pastes/expired/delete', [DashboardController::class, 'destroyExpired'])->name('pastes.expired.delete');
    });
});

// Public paste routes
Route::get('/', [PasteController::class, 'index'])->name('pastes.index');
Route::get('/create', [PasteController::class, 'create'])->name('pastes.create');
Route::post('/pastes', [PasteController::class, 'store'])->name('pastes.store');
Route::get('/{slug}', [PasteController::class, 'show'])->name('pastes.show')->middleware(['paste.expiry', 'paste.password']);
Route::get('/{slug}/raw', [PasteController::class, 'raw'])->name('pastes.raw')->middleware('paste.expiry');
Route::get('/{slug}/password', [PasteController::class, 'passwordForm'])->name('pastes.password');
Route::post('/{slug}/password', [PasteController::class, 'passwordSubmit'])->name('pastes.password.submit');
