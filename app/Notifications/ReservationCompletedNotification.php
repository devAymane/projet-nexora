<?php

namespace App\Notifications;

use App\Models\Reservation;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ReservationCompletedNotification extends Notification
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
            'type' => 'reservation_completed',
            'reservation_id' => $this->reservation->id,
            'service_id' => $this->reservation->service_id,
            'message' => 'Votre réservation est terminée. Vous pouvez maintenant laisser un avis.',
        ];
    }
}