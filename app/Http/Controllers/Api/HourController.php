<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Project;
use App\User;
use App\Hour;
use Validator;
use JWTAuth;
use Response;

class HourController extends Controller
{
    //
    public function addHour(Request $request) {
		try{
		   $user = JWTAuth::parseToken()->toUser();
		}catch (\Exception $e){
		   echo json_encode([$e->getMessage()]);
		   exit();
		}
		$validator = Validator::make($request->all(), [
			'project_id' => 'required',
            'start_time'=> 'nullable',
            'end_time'=> 'nullable',
            'hour'=> 'nullable',
            'min'=> 'nullable'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $hour = new Hour;
		$hour->project_id = $request->project_id;
		$hour->date = $request->date;
		$hour->start_time = $request->start_time;
		$hour->end_time = $request->end_time;
		$hour->hour = $request->hour;
		$hour->min = $request->min;
        $hour->save();
        
        return Response::json(array('status' => true, 'message' => 'Hours Added Successfully.' ));
    }

}
