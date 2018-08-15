<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use JWTFactory;
use JWTAuth;
use Validator;
use Response;
use Hash;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('guest')->except('logout');
    }
	
	public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255|unique:users',
            'name' => 'required',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        User::create([
            'name' => $request->get('name'),
            'email' => $request->get('email'),
            'password' => bcrypt($request->get('password')),
        ]);
        $user = User::first();
        $token = JWTAuth::fromUser($user);
        
        return Response::json(compact('token','user'));
    }
	
	 public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email|max:255',
            'password'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $credentials = $request->only('email', 'password');
        try {
            if (! $token = JWTAuth::attempt($credentials)) {
                return response()->json(['error' => 'invalid_credentials'], 401);
            }
        } catch (JWTException $e) {
            return response()->json(['error' => 'could_not_create_token'], 500);
        }
		$user = JWTAuth::toUser($token);
        return response()->json(compact('token','user'));
    }
	
	public function changePassword(Request $request){
		try{
		   $user = JWTAuth::parseToken()->toUser();
		}catch (\Exception $e){
		   echo json_encode([$e->getMessage()]);
		   exit();
		}
		$validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'password'=> 'required|confirmed',
            'password_confirmation'=> 'required',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
		
		 if(crypt($request->old_password,$user->password) === $user->password)
       {

           $user->password = Hash::make($request->password);
           $user->save();
           $status=true;
           $message = "Password changed successfully.";
           return response()->json(compact('status','message'));

       }else{
           $status=false;
           $error='Old password is wrong';
           return response()->json(compact('status','error'),400);
       }
		
	}
	
}
