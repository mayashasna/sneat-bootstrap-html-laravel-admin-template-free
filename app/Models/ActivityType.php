<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperActivityType
 */
class ActivityType extends Model
{
    protected $fillable = [
        'name_ar',
        'name_en',
        'is_active',
    ];
}
