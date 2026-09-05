<?php

namespace App\Listeners;

use App\Events\ReservationCreated;
use App\Jobs\SendReservationNotification;

class QueueReservationNotification
{
    public function handle(ReservationCreated $event): void
    {
        SendReservationNotification::dispatch(
            $event->reservation->id
        );
    }
}