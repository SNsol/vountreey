<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //
	protected $fillable = [
        'title', 'description',
    ];
	
	public function users(){
		return $this->belongsToMany(User::Class, 'user_project', 'project_id', 'user_id');
	}
}
