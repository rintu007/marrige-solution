<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserLog extends Model
{
    public function addedBy()
    {
    	return $this->belongsTo('App\Model\User', 'addedby_id')->withoutGlobalScopes();
    }

    public function user()
    {
    	return $this->belongsTo('App\Model\User', 'user_id')->withoutGlobalScopes();
    }

 
}
