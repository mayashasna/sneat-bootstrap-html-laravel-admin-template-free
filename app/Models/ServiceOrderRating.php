<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrderRating extends Model
{
    protected $fillable = [
        'order_id',
        'requester_business_id',
        'provider_business_id',
        'rating',
        'comment',
    ];

    public function order()
    {
        return $this->belongsTo(ServiceOrder::class, 'order_id');
    }

    public function requester()
    {
        return $this->belongsTo(BusinessAccount::class, 'requester_business_id');
    }

    public function provider()
    {
        return $this->belongsTo(BusinessAccount::class, 'provider_business_id');
    }
}
