<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminFcmToken extends Model
{
    protected $fillable = ['admin_id', 'token'];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}
