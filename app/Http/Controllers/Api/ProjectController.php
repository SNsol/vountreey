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

class ProjectController extends Controller
{
    //
	public function addProject(Request $request){
		try{
		   $user = JWTAuth::parseToken()->toUser();
		}catch (\Exception $e){
		   echo json_encode([$e->getMessage()]);
		   exit();
		}
		$validator = Validator::make($request->all(), [
			'title' => 'required',
            'description'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
		
		/*
		$project = new Project;
		$project->title = $request->title;
		$project->description = $request->description;
		$project->save();
		
		$user = User::find($user->id);
		$user->projects()->attach($project);
		*/
		$user->projects()->create($request->all());
		
		return Response::json(array('status' => true, 'message' => 'Added Successfully.' ));
	}
	
	public function projectList(Request $request){
		try{
		   $user = JWTAuth::parseToken()->toUser();
		}catch (\Exception $e){
		   echo json_encode([$e->getMessage()]);
		   exit();
		}
		$project = User::with('projects')->find($user->id);
		foreach($project->projects as $key => $value){
			$date = date('Y-m-d',strtotime($value->created_at));
			$data[$key]['id'] = $value->id;
			$data[$key]['title'] = $value->title;
			$data[$key]['description'] = $value->description;
			$data[$key]['create_date'] = $date;
			$hours = Hour::where('project_id',$value->id)->get();
			$data[$key]['hours'] = $hours;
		}
		return Response::json(array('status' => true, 'data' => $data ));
	}
	
	public function updateProject(Request $request){
		$validator = Validator::make($request->all(), [
			'project_id' => 'required',
			'title' => 'required',
            'description'=> 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
		$project = Project::find($request->project_id);
		$project->title = $request->title;
		$project->description = $request->description;
		$project->save();
		return Response::json(array('status' => true, 'message' => 'Updated Successfully.' ));
	}

	public function projectDetails(Request $request){
		$validator = Validator::make($request->all(), [
			'project_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
		$project = Project::find($request->project_id);
		return Response::json(array('status' => true, 'data' => $project ));
	}
	
	public function removeProject(Request $request){
		try{
		   $user = JWTAuth::parseToken()->toUser();
		}catch (\Exception $e){
		   echo json_encode([$e->getMessage()]);
		   exit();
		}
		$validator = Validator::make($request->all(), [
			'project_id' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $project = Project::find($request->project_id);
		$project->delete();
        $user->projects()->detach($project);
        return Response::json(array('status' => true, 'message' => 'Deleted Successfully.' ));
        
	}
	
}
