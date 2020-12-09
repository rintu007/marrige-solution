<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class BlogParameter extends Model
{
    public function logo()
    {
    	if($this->logo)
    	{
    		return "storage/logo/{$this->logo}";
    	}
    	return null;
    }
}
