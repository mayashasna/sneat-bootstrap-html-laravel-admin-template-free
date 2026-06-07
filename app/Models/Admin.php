<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

/**
 * @mixin IdeHelperAdmin
 */
class Admin extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $guard_name = 'admin'; // ⭐ مهم جداً

    protected $fillable = [
        'name',
        'email',
        'password',
        'is_super',  
        'status',
    ];

    protected $hidden = [
        'password',
    ];
}
