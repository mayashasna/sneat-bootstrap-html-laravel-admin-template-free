<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperRole
 */
class Role extends Model
{
   protected $fillable = ['name', 'display_name', 'guard_name'];

}