<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
   protected $fillable = [
        'user_id',
        'user_second_id'
        
    ];

     //notifications
	  public function notifications()
	  {
	    return $this->morphMany('App\Model\Notification', 'notifiable');
	  }
}
