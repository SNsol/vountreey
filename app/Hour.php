<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hour extends Model
{
    public function projects(){
		return $this->belongsTo('App\Project');
	}
}
