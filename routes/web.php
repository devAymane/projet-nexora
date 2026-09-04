<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\AvisController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ConversationController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ClientDashboardController;
use App\Http\Controllers\ProviderDashboardController;

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
    $user = request()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    }

    if ($user->hasRole('provider')) {
        return redirect()->route('provider.dashboard');
    }

    return redirect()->route('client.dashboard');
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


        // Conversations
Route::get('/conversations', [ConversationController::class, 'index'])
    ->name('conversations.index');

Route::get('/conversations/create/{user}', [ConversationController::class, 'create'])
    ->name('conversations.create');

Route::get('/conversations/{conversation}', [ConversationController::class, 'show'])
    ->name('conversations.show');

// Messages
Route::post('/conversations/{conversation}/messages', [MessageController::class, 'store'])
    ->name('messages.store');

Route::patch('/messages/{message}/read', [MessageController::class, 'read'])
    ->name('messages.read');


    /*
|--------------------------------------------------------------------------
| Notifications Routes
|--------------------------------------------------------------------------
*/

Route::get('/notifications', [NotificationController::class, 'index'])
    ->name('notifications.index');

Route::patch('/notifications/{notification}/read', [NotificationController::class, 'read'])
    ->name('notifications.read');

Route::patch('/notifications/read-all', [NotificationController::class, 'readAll'])
    ->name('notifications.readAll');



});







Route::patch('/reservations/{reservation}/complete', [ReservationController::class, 'complete'])
    ->name('reservations.complete');






    /* Avis */
Route::middleware('auth')->group(function () {
    Route::get('/reservations/{reservation}/avis/create', [AvisController::class, 'create'])
        ->name('avis.create');

    Route::post('/avis', [AvisController::class, 'store'])
        ->name('avis.store');
});







Route::middleware('auth')->group(function () {

    Route::get('/avis', [AvisController::class, 'index'])
        ->name('avis.index');

    Route::get('/reservations/{reservation}/avis/create', [AvisController::class, 'create'])
        ->name('avis.create');

    Route::post('/avis', [AvisController::class, 'store'])
        ->name('avis.store');
});





Route::middleware('auth')->group(function () {
    Route::post('/services/{service}/favorite', [FavoriteController::class, 'store'])
        ->name('favorites.store');

    Route::delete('/services/{service}/favorite', [FavoriteController::class, 'destroy'])
        ->name('favorites.destroy');
});


Route::get('/favorites', [FavoriteController::class, 'index'])
    ->name('favorites.index');

Route::post('/services/{service}/favorite', [FavoriteController::class, 'store'])
    ->name('favorites.store');

Route::delete('/services/{service}/favorite', [FavoriteController::class, 'destroy'])
    ->name('favorites.destroy');









    Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/client/dashboard', [ClientDashboardController::class, 'index'])
        ->middleware('nexora.role:client')
        ->name('client.dashboard');

    Route::get('/provider/dashboard', [ProviderDashboardController::class, 'index'])
        ->middleware('nexora.role:provider')
        ->name('provider.dashboard');

    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
        ->middleware('nexora.role:admin')
        ->name('admin.dashboard');

});














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