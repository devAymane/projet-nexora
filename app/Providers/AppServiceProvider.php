<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\Service;
use App\Policies\CategoryPolicy;
use App\Policies\ServicePolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
    }
}