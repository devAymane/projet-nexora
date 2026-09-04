<?php

namespace App\Listeners;

use App\Events\ReservationCompleted;
use App\Notifications\ReservationCompletedNotification;

class SendReservationCompletedNotification
{
    public function handle(ReservationCompleted $event): void
    {
        $reservation = $event->reservation->load('user');

        $reservation->user->notify(
            new ReservationCompletedNotification($reservation)
        );
    }
}