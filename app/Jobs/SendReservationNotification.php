<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Notifications\ReservationCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendReservationNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, SerializesModels;

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