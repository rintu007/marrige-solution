<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ServicePost extends Model
{
    public function addedBy(){
		return $this->belongsTo('App\Model\User','addedby_id');
	}
   
	public function imgFeature()
	{
	    if($this->feature_img_name)
	    {
	        return true;
	    }else
	    {
	        return false;
	    }
	}

	public function fi()
	{
		if($this->imgFeature())
		{
			return "/storage/media/image/{$this->feature_img_name}";
		}
		else{
			return "img/fi.png";
		}
	}

	public function fiName()
	{
		if($this->imgFeature())
		{
			return $this->feature_img_name;
		}
		else{
			return "fi.png";
		}
	}
}
