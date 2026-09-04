<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationRefusedNotification extends Notification
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
            'type' => 'reservation_refused',
            'reservation_id' => $this->reservation->id,
            'service_id' => $this->reservation->service_id,
            'message' => 'Votre réservation a été refusée.',
        ];
    }
}