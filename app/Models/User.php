<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;

class User extends Authenticatable implements LaratrustUser
{
    use HasFactory, Notifiable, HasRolesAndPermissions;

    protected $fillable = [
        'nom',
        'prenom',
        'email',
        'password',
        'telephone',
        'photo',
        'pays',
        'ville',
        'description',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }

    public function reservations(): HasMany
    {
        return $this->hasMany(Reservation::class);
    }

    public function clientConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'client_id');
    }

    public function providerConversations(): HasMany
    {
        return $this->hasMany(Conversation::class, 'provider_id');
    }

    public function messages(): HasMany
    {
        return $this->hasMany(Message::class);
    }

    public function avis(): HasMany
    {
        return $this->hasMany(Avis::class);
    }

    public function favorites(): HasMany
    {
        return $this->hasMany(Favorite::class);
    }
}