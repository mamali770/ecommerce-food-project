<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function loginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'regex:/^09[0|1|2|3][0-9]{8}$/'],
        ]);

        $user = User::where('phone', $request->phone)->first();
        $otpCode = mt_rand(1000, 99999);
        $loginToken = Hash::make('FBScslddsh$&clsdc*dcncd@DCD');

        if ($user) {
            $user->update([
                'otp' => $otpCode,
                'login_token' => $loginToken,
                'otp_expired_at' => Carbon::now()->addMinutes(3)
            ]);
        } else {
            $user = User::create([
                'phone' => $request->phone,
                'otp' => $otpCode,
                'login_token' => $loginToken,
                'otp_expired_at' => Carbon::now()->addMinutes(3)
            ]);
        }

        // sendOtpSms($request->phone, $otpCode);

        return response()->json(['login_token' => $loginToken], 200);
    }

    public function checkOtp(Request $request)
    {
        $request->validate([
            'otp' => "required|digits:5",
            'login_token' => "required"
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->where('otp_expired_at', '>', Carbon::now())->first();

            if ($user->otp == $request->otp) {
                $user->update([
                    'otp_verified_at' => Carbon::now()
                ]);
                auth()->login($user, $remember = true);
                return response()->json(['message' => "ورود با موفقیت انجام شد!"], 200);
            } elseif(!$user) {
                return response()->json(['message' => 'کد منقضی شده است'], 422);
            } else {
                return response()->json(['message' => 'کد ورود نادرست است'], 422);
            }
        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }

    public function resendOtp(Request $request)
    {
        $request->validate([
            'login_token' => "required"
        ]);

        try {
            $user = User::where('login_token', $request->login_token)->first();
            $otpCode = mt_rand(1000, 99999);
            $loginToken = Hash::make('FBScslddsh$&clsdc*dcncd@DCD');

            if ($user) {
                $user->update([
                    'otp' => $otpCode,
                    'login_token' => $loginToken
                ]);
            }

            // sendOtpSms($request->phone, $otpCode);

            return response()->json(['login_token' => $loginToken], 200);
        } catch (\Exception $ex) {
            return response()->json(['errors' => $ex->getMessage()], 500);
        }
    }
}
