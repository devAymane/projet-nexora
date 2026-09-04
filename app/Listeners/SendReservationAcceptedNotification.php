<?php

namespace App\Listeners;

use App\Events\ReservationAccepted;
use App\Notifications\ReservationAcceptedNotification;

class SendReservationAcceptedNotification
{
    public function handle(ReservationAccepted $event): void
    {
        $reservation = $event->reservation->load('user');

        $reservation->user->notify(
            new ReservationAcceptedNotification($reservation)
        );
    }
}