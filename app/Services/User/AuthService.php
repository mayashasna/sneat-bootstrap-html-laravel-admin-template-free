<?php

namespace App\Services\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\User\OtpService;

class AuthService
{
    protected $otpService;

    public function __construct(OtpService $otpService)
    {
        $this->otpService = $otpService;
    }

    public function register($data)
    {
        $otp = rand(100000, 999999);

        $user = User::create([
            'name'           => $data['name'],
            'phone'          => $data['phone'],
            'password'       => bcrypt($data['password']),
            'otp_code'       => $otp,
            'otp_expires_at' => now()->addMinutes(10),
            'status'         => 'pending',
            'otp_last_sent_at' => now(),
        ]);

        $this->otpService->sendOtp($user->phone, $otp);

        return [
            'status'  => true,
            'message' => 'تم إنشاء الحساب، تم إرسال كود التفعيل على الواتساب',
            'otp'     => $otp, // للتجربة فقط
            'code'    => 201
        ];
    }

    public function verifyOtp($data)
    {
        $user = User::where('phone', $data['phone'])->first();

        if (! $user) {
            return [
                'status'  => false,
                'message' => 'المستخدم غير موجود',
                'code'    => 404
            ];
        }

        if ($user->status === 'active') {
            return [
                'status'  => false,
                'message' => 'الحساب مفعل مسبقًا',
                'code'    => 400
            ];
        }

        if ($user->otp_code != $data['otp_code']) {
            return [
                'status'  => false,
                'message' => 'كود التفعيل غير صحيح',
                'code'    => 422
            ];
        }

        if ($user->otp_expires_at && $user->otp_expires_at->isPast()) {
            return [
                'status'  => false,
                'message' => 'انتهت صلاحية كود التفعيل، اطلب كود جديد',
                'code'    => 422
            ];
        }

        $user->update([
            'status'   => 'active',
            'otp_code' => null,
        ]);

        $token = $user->createToken('user_token')->accessToken;

        return [
            'status'  => true,
            'message' => 'تم تفعيل الحساب بنجاح',
            'token'   => $token,
            'user'    => $user,
            'code'    => 200
        ];
    }

   public function login($data)
{
    $user = User::where('phone', $data['phone'])->first();

    if (! $user || ! Hash::check($data['password'], $user->password)) {
        return [
            'status'  => false,
            'message' => 'Invalid phone number or password',
            'code'    => 401
        ];
    }

    if ($user->status !== 'active') {
        return [
            'status'  => false,
            'message' => 'Account is not activated. Please verify your account using the OTP code',
            'code'    => 403
        ];
    }

    $token = $user->createToken('user_token')->accessToken;

    return [
        'status'  => true,
        'message' => 'Login successful',
        'token'   => $token,
        'user'    => $user,
        'code'    => 200
    ];
}

    public function resendOtp($data)
    {
        $user = User::where('phone', $data['phone'])->first();

        if (!$user) {
            return [
                'status'  => false,
                'message' => 'User not found ',
                'code'    => 404
            ];
        }

        if ($user->status === 'active') {
            return [
                'status'  => false,
                'message' => 'The account is already activated; a new code cannot be sent.',
                'code'    => 400
            ];
        }

        if ($user->otp_last_sent_at && $user->otp_last_sent_at->diffInSeconds(now()) < 30) {
    $secondsLeft = 30 - $user->otp_last_sent_at->diffInSeconds(now());

            return [
                'status'  => false,
                'message' => "Please wait{$secondsLeft} Second before requesting a new code",
                'code'    => 429
            ];
        }

        $otp = rand(100000, 999999);

        $user->otp_code = $otp;
        $user->otp_expires_at = now()->addMinutes(5);
        $user->otp_last_sent_at = now();
        $user->save();

        $this->otpService->sendOtp($user->phone, $otp);

        return [
            'status'  => true,
            'message' =>' A new code has been successfully sent',
            'code'    => 200
        ];
    }
}
