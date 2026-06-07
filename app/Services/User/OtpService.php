<?php

namespace App\Services\User;

use Illuminate\Support\Facades\Http;

class OtpService
{
    protected $instanceId;
    protected $token;

    public function __construct()
    {
        $this->instanceId = config('services.ultramsg.instance_id');
        $this->token = config('services.ultramsg.token');
    }

    public function sendOtp($phone, $otp)
    {
        $url = "https://api.ultramsg.com/{$this->instanceId}/messages/chat";

        $message = " Your activation code is: {$otp}";


        $response = Http::withoutVerifying()->asForm()->post($url, [
            'token' => $this->token,
            'to'    => $phone,
            'body'  => $message,
        ]);

        return $response->successful();
    }
}
