<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conversation extends Model
{
    protected $fillable = ['service_id'];

    public function participants()
{
    return $this->belongsToMany(
        User::class,
        'conversation_participants',
        'conversation_id',
        'user_id'
    );
}


    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function service()
{
    return $this->belongsTo(Service::class, 'service_id');
}
public function lastMessage()
{
    return $this->hasOne(Message::class)
        ->latestOfMany();
}

}
