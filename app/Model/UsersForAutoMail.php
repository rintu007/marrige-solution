<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UsersForAutoMail extends Model
{
   public function user()
   {
   		return $this->belongsTo('App\Model\User');
   }

   public function items()
   {
   		return $this->hasMany('App\Model\UsersForAutoMailItem', 'automail_id');
   }
}
