<?php

namespace App\Listeners;

use App\Events\ReservationAccepted;
use App\Jobs\SendReservationNotification;

class SendReservationAcceptedNotification
{
    public function handle(ReservationAccepted $event): void
    {
        SendReservationNotification::dispatch(
            $event->reservation->id,
            'accepted'
        );
    }
}