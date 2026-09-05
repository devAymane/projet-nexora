<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Reservation $reservation
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'reservation_created',
            'reservation_id' => $this->reservation->id,
            'service_id' => $this->reservation->service_id,
            'message' => 'Une nouvelle réservation a été créée pour votre service.',
        ];
    }
}