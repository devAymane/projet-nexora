<?php

namespace App\Events;

use App\Models\Reservation;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ReservationRefused
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public Reservation $reservation
    ) {
    }
}