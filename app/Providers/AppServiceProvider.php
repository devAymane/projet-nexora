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
use App\Models\Conversation;
use App\Models\Message;
use App\Policies\ConversationPolicy;
use App\Policies\MessagePolicy;
use App\Events\ReservationAccepted;
use App\Events\ReservationCompleted;
use App\Events\ReservationCreated;
use App\Events\ReservationRefused;
use App\Listeners\SendReservationAcceptedNotification;
use App\Listeners\SendReservationCompletedNotification;
use App\Listeners\SendReservationCreatedNotification;
use App\Listeners\SendReservationRefusedNotification;
use Illuminate\Support\Facades\Event;





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
    Gate::policy(Conversation::class, ConversationPolicy::class);
Gate::policy(Message::class, MessagePolicy::class);



Event::listen(
    ReservationCreated::class,
    SendReservationCreatedNotification::class
);

Event::listen(
    ReservationAccepted::class,
    SendReservationAcceptedNotification::class
);

Event::listen(
    ReservationRefused::class,
    SendReservationRefusedNotification::class
);

Event::listen(
    ReservationCompleted::class,
    SendReservationCompletedNotification::class
);
    }
}