<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
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









/*
|--------------------------------------------------------------------------
| Services Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/services', [ServiceController::class, 'index'])
        ->name('services.index');

    Route::get('/services/create', [ServiceController::class, 'create'])
        ->name('services.create');

    Route::post('/services', [ServiceController::class, 'store'])
        ->name('services.store');

    Route::get('/services/{service}', [ServiceController::class, 'show'])
        ->name('services.show');

    Route::get('/services/{service}/edit', [ServiceController::class, 'edit'])
        ->name('services.edit');

    Route::put('/services/{service}', [ServiceController::class, 'update'])
        ->name('services.update');

    Route::delete('/services/{service}', [ServiceController::class, 'destroy'])
        ->name('services.destroy');
});







/*
|--------------------------------------------------------------------------
| Categories Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'nexora.role:admin'])->group(function () {

    Route::resource('categories', CategoryController::class);

});









/*
|--------------------------------------------------------------------------
| Users Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'nexora.role:admin'])->group(function () {
    Route::resource('users', UserController::class);

    Route::patch('/users/{user}/role', [UserController::class, 'updateRole'])
        ->name('users.update-role');
});









/*
|--------------------------------------------------------------------------
| Reservations Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/reservations', [ReservationController::class, 'index'])
        ->name('reservations.index');

    Route::get('/reservations/create', [ReservationController::class, 'create'])
        ->name('reservations.create');

    Route::post('/reservations', [ReservationController::class, 'store'])
        ->name('reservations.store');

    Route::get('/reservations/{reservation}', [ReservationController::class, 'show'])
        ->name('reservations.show');

    Route::patch('/reservations/{reservation}/cancel', [ReservationController::class, 'cancel'])
        ->name('reservations.cancel');

    Route::patch('/reservations/{reservation}/accept', [ReservationController::class, 'accept'])
        ->name('reservations.accept');

    Route::patch('/reservations/{reservation}/refuse', [ReservationController::class, 'refuse'])
        ->name('reservations.refuse');

    Route::patch('/reservations/{reservation}/complete', [ReservationController::class, 'complete'])
        ->name('reservations.complete');
});







Route::patch('/reservations/{reservation}/complete', [ReservationController::class, 'complete'])
    ->name('reservations.complete');