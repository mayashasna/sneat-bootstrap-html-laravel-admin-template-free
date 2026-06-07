<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderImage extends Model
{
    public $timestamps = false;

    protected $fillable = ['path', 'created_at'];
}
