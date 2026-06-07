<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceFieldValue extends Model
{
    protected $fillable = ['service_id', 'field_id', 'value'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function field()
    {
        return $this->belongsTo(Field::class);
    }
}

