<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperUser
 */
/**
 * @property \Illuminate\Database\Eloquent\Collection $businessAccounts
 */

class User extends Authenticatable
{
    use HasApiTokens, Notifiable , HasRoles;

    protected $fillable = [
        'name',
        'phone',
        'password',
        'otp_code',
        'otp_expires_at',
        'status',
    ];

    protected $hidden = [
        'password',
        'otp_code',
    ];
    protected $casts = [
    'otp_expires_at' => 'datetime',
];
public function businessAccounts()
{
    return $this->hasMany(\App\Models\BusinessAccount::class, 'user_id');
}
public function devices()
{
    return $this->hasMany(DeviceToken::class);
}
public function favoriteServices()
{
    return $this->belongsToMany(
        \App\Models\Service::class,
        'service_favorites',
        'user_id',
        'service_id'
    )->withTimestamps();
}
public function conversations()
{
    return $this->belongsToMany(
        \App\Models\Conversation::class,
        'conversation_participants',
        'user_id',
        'conversation_id'
    );
}
}
