<?php

namespace App\Listeners;

use App\Events\ReservationRefused;
use App\Jobs\SendReservationNotification;

class SendReservationRefusedNotification
{
    public function handle(ReservationRefused $event): void
    {
        SendReservationNotification::dispatch(
            $event->reservation->id,
            'refused'
        );
    }
}