<?php

namespace App\Http\Controllers\Auth;

use App\Services\VonageSmsService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendVerificationOtpRequest;
use App\Http\Requests\Auth\VerifyAccountRequest;
use App\Mail\VerifyAccountMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerifyAccountController extends Controller
{
        public function sendOtp(SendVerificationOtpRequest $request, VonageSmsService $sms){

        $type = filter_var($request->input('identifier'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';
        $user = User::where($type, $request->identifier)->first();

        if($user->account_verified_at){
            return redirect()->to('login')->with('success', 'you are already verified!');
        }

        if($request->input('method') == 'email'){
            Mail::to($user->email)->send(new VerifyAccountMail($user->otp, $user->email));
        } 

        if($request->input('method') == 'phone')
        {   
            if(!$user->phone || $user->phone == '')
            {
                return back()->with('error', 'You do not have a phone number!');
            }
            $sms->send($user->phone, 'Your verification OTP is: ' . $user->otp);
            
        }

        return redirect()->route('account.verify', $request->input('method') == 'phone'? $user->phone : $user->email); 
    }
    public function verifyOtp(VerifyAccountRequest $request)
    {
        $type = filter_var($request->input('identifier'), FILTER_VALIDATE_EMAIL) ? 'email' : 'phone';

        $user = User::where($type, $request->identifier)->first();
        if($user->otp != implode("", $request->otp)){
            return back()->with('error', 'Invalid OTP or account data');
        };

        $user->account_verified_at = now();
        $user->save();

        return redirect()->route('login')->with('success', 'Your Account verified successfully, you can login now');
    }
}