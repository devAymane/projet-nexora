<?php

namespace App\Listeners;

use App\Events\ReservationCreated;
use App\Notifications\ReservationCreatedNotification;

class SendReservationCreatedNotification
{
    public function handle(ReservationCreated $event): void
    {
        $reservation = $event->reservation->load('service.user');

        $provider = $reservation->service->user;

        $provider->notify(
            new ReservationCreatedNotification($reservation)
        );
    }
}