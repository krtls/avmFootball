<?php

use App\Livewire\PlayerShotSpeedBoard;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome')->name('home');
Route::middleware(['auth'])->group(function () {
    Route::get('/shot-speed', PlayerShotSpeedBoard::class)->name('shot-speed.index');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');
});

require __DIR__.'/settings.php';
