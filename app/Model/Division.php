<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{
 	public function posts(){
		return $this->belongsToMany('App\Model\Blog', 'post_divisions', 'division_id', 'post_id');
	}

	public function hasPost($post){
		$row = $this->posts()->where('blogs.id',$post->id)->first();
		if($row){
			return true;
		}
		return false;
	}

	public function districts()
	{
		return $this->hasMany('App\Model\District','division_id');
	}

	public function thanas()
	{
		return $this->hasMany('App\Model\Upazila','division_id');
	}
}
