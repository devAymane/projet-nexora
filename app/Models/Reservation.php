<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'service_id',
        'date',
        'message',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'datetime',
        ];
    }

    /**
     * Client qui a effectué la réservation.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Service réservé.
     */
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    /**
     * Avis lié à cette réservation.
     */
    public function avis(): HasOne
    {
        return $this->hasOne(Avis::class);
    }
}