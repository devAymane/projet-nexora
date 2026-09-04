<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'category_id',
        'titre',
        'description',
        'prix',
        'ville',
        'image',
        'disponibilite',
        'statut',
    ];

    protected function casts(): array
    {
        return [
            'prix' => 'decimal:2',
            'disponibilite' => 'boolean',
        ];
    }

    /**
     * Prestataire qui a publié le service.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Catégorie du service.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Réservations du service.
     */
    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    /**
     * Avis du service.
     */
    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class);
    }

    /**
     * Favoris du service.
     */
    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}