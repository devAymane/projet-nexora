<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| Dashboard
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'nexora.role:admin'])->group(function () {

    Route::get('/admin/test', function () {
        return 'Admin access OK';
    })->name('admin.test');

});

/*
|--------------------------------------------------------------------------
| Client Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'nexora.role:client'])->group(function () {

    Route::get('/client/test', function () {
        return 'Client access OK';
    })->name('client.test');

});

/*
|--------------------------------------------------------------------------
| Provider Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'nexora.role:provider'])->group(function () {

    Route::get('/provider/test', function () {
        return 'Provider access OK';
    })->name('provider.test');

});

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';