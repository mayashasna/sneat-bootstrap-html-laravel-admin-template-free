<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceOrder extends Model
{
    protected $fillable = [
        'service_id',
        'requester_business_id',
        'provider_business_id',
        'quantity',
        'needed_at',
        'details',
        'status',
         'reject_reason',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function requesterBusiness()
    {
        return $this->belongsTo(BusinessAccount::class, 'requester_business_id');
    }

    public function providerBusiness()
    {
        return $this->belongsTo(BusinessAccount::class, 'provider_business_id');
    }

}
