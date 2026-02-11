<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sini Anda dapat mendaftarkan rute web untuk aplikasi Anda. 
| Rute-rute ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditetapkan ke grup middleware "web".
|
*/

// Halaman Landing Page Bawaan
Route::get('/', function () {
    return view('welcome');
});

/**
 * Monitoring Dashboard (Poin 4 dalam Proposal)
 * Route ini digunakan oleh Admin untuk memantau log pengiriman WhatsApp.
 */
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');