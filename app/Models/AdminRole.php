<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperAdminRole
 */
class AdminRole extends Model
{
    protected $table = 'admin_role';

    protected $fillable = [
        'admin_id',
        'role_id',
    ];
}