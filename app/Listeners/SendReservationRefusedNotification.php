<?php

namespace App\Listeners;

use App\Events\ReservationRefused;
use App\Notifications\ReservationRefusedNotification;

class SendReservationRefusedNotification
{
    public function handle(ReservationRefused $event): void
    {
        $reservation = $event->reservation->load('user');

        $reservation->user->notify(
            new ReservationRefusedNotification($reservation)
        );
    }
}