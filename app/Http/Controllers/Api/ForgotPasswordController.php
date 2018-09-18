<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use App\Mail\SendApiPasswordMail;
use Validator;
use App\User;
use DB;
use URL;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }
	
	public function sendResetLink(Request $request){
		$validator = Validator::make($request->all(), [
			'email' => 'required|email'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
		$user = User::where('email',$request->email)->first();
		if($user){
			$token = str_random(60);
			DB::table('password_resets')->insert([
				'email' => $request->email,
				'token' => $token, //change 60 to any length you want
            ]);
            $token = URL::to('forgot_password/reset/'.$token);
			$res = Mail::to($request->email)->subject('Recover your password!')->send(new SendApiPasswordMail($token));
			return response()->json(['status' => '1','msg' => 'Email Send Successfully.']);
		}else{
			return response()->json(['status' => '0','error' => 'Email does not exists.']);
		}
	}
}
