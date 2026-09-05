<?php

namespace App\Jobs;

use App\Models\Reservation;
use App\Notifications\ReservationAcceptedNotification;
use App\Notifications\ReservationCompletedNotification;
use App\Notifications\ReservationCreatedNotification;
use App\Notifications\ReservationRefusedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;

class SendReservationNotification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public int $reservationId,
        public string $notificationType = 'created',
    ) {
    }

    public function handle(): void
    {
        $reservation = Reservation::with([
            'user',
            'service.user',
        ])->findOrFail($this->reservationId);

        $notification = match ($this->notificationType) {
            'created' => new ReservationCreatedNotification($reservation),
            'accepted' => new ReservationAcceptedNotification($reservation),
            'refused' => new ReservationRefusedNotification($reservation),
            'completed' => new ReservationCompletedNotification($reservation),
            default => throw new \InvalidArgumentException(
                "Unknown reservation notification type: {$this->notificationType}"
            ),
        };

        if ($this->notificationType === 'created') {
            $reservation->service->user->notify($notification);
            return;
        }

        $reservation->user->notify($notification);
    }
}