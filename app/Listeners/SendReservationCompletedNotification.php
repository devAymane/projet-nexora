<?php

namespace App\Listeners;

use App\Events\ReservationCompleted;
use App\Jobs\SendReservationNotification;

class SendReservationCompletedNotification
{
    public function handle(ReservationCompleted $event): void
    {
        SendReservationNotification::dispatch(
            $event->reservation->id,
            'completed'
        );
    }
}