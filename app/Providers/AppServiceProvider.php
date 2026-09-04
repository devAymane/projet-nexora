<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Reservation;
use App\Models\Service;
use App\Models\User;
use App\Policies\CategoryPolicy;
use App\Policies\ReservationPolicy;
use App\Policies\ServicePolicy;
use App\Policies\UserPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use App\Models\Avis;
use App\Policies\AvisPolicy;
use App\Models\Favorite;
use App\Policies\FavoritePolicy;


class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        Gate::policy(Service::class, ServicePolicy::class);
        Gate::policy(Category::class, CategoryPolicy::class);
        Gate::policy(User::class, UserPolicy::class);
        Gate::policy(Reservation::class, ReservationPolicy::class);
            Gate::policy(Reservation::class, ReservationPolicy::class);
    Gate::policy(Avis::class, AvisPolicy::class);
    Gate::policy(Favorite::class, FavoritePolicy::class);
    }
}