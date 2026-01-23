<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthPageController;
use App\Http\Controllers\DashboardController;
Route::get('log', [AuthPageController::class, 'login'])
    ->name('log');

Route::middleware(['auth', 'verified','role:STUDENT'])->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('home');
    Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');
    Route::get('/universities/{university}', [HomeController::class, 'show'])
        ->name('universities.show');
    
});

require __DIR__.'/settings.php';
