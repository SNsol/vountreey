<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Validator;
use App\User;
use Redirect;
use Hash;
use DB;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest');
    }
	
	public function resetForm($token){
        $check = DB::table('password_resets')->where('token',$token)->first();
        if($check){
            return view('auth.passwords.api_reset',compact('token'));
        }else{
            echo '<h2 style="color:red;text-align:center;"><i>Token Has Been Expired, Please Try Again.</i></h2>';
        }
    }
    
    public function reset(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);

        if ($validator->fails()) {
            return back()
                        ->withErrors($validator)
                        ->withInput();
        }
        $check = DB::table('password_resets')->where('email',$request->email)->where('token',$request->token)->first();
		if($check){
            DB::table('password_resets')->where('token',$check->token)->delete();
            $user = User::where('email',$request->email)->first();
            $user->password = Hash::make($request->password);
            $user->save(); 
            $success = "Password has reset successfully!!";
            return view('auth.passwords.api_reset_success',compact('success'));
        }else{
            return Redirect::back()->withErrors(['Email is not correct.']);
        }
    }
	
}
