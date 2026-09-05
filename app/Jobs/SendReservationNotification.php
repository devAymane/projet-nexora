<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Notifications\ReservationCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendReservationNotification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $reservationId
    ) {
    }

    public function handle(): void
    {
        $reservation = Reservation::with('service.user')
            ->findOrFail($this->reservationId);

        $provider = $reservation->service->user;

        $provider->notify(
            new ReservationCreatedNotification($reservation)
        );
    }
}