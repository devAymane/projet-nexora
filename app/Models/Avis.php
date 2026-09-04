<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Avis extends Model
{
    use HasFactory;

    protected $fillable = [
        'reservation_id',
        'user_id',
        'service_id',
        'note',
        'commentaire',
        'date',
    ];

    protected function casts(): array
    {
        return [
            'note' => 'integer',
            'date' => 'datetime',
        ];
    }

    /**
     * Réservation liée à l'avis.
     */
    public function reservation(): BelongsTo
    {
        return $this->belongsTo(Reservation::class);
    }

    /**
     * Utilisateur qui a rédigé l'avis.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Service évalué.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}