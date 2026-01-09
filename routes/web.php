<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdController;
use Illuminate\Support\Facades\Auth;

// При заходе на сайт — если не вошел, кидает на login
Route::get('/', function () {
    return Auth::check() ? redirect()->route('ads.index') : redirect()->route('login');
});

Auth::routes();

// Все действия доступны только после входа
Route::middleware(['auth'])->group(function () {
    Route::get('/ads', [AdController::class, 'index'])->name('ads.index');
    Route::get('/ads/my', [AdController::class, 'myAds'])->name('ads.my'); // Вот этот маршрут
    Route::get('/ads/create', [AdController::class, 'create'])->name('ads.create');
    Route::post('/ads', [AdController::class, 'store'])->name('ads.store');
    Route::get('/ads/{ad}', [AdController::class, 'show'])->name('ads.show');
    Route::get('/ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit');
    Route::put('/ads/{ad}', [AdController::class, 'update'])->name('ads.update');
    Route::delete('/ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy');
});