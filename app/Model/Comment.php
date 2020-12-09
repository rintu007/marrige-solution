<?php

namespace App\Model;

use Auth;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
   public function addedBy(){
   	return $this->belongsTo('App\Model\User', 'addedby_id');
   }

   public function post(){
   	return $this->belongsTo('App\Model\Blog','post_id');
   }

   public function deletePermission()
   {
   		if( 

   			$this->post->addedBy->id == Auth::id() 
   			|| $this->addedby_id == Auth::id() 
   			|| Auth::user()->isAdmin() 
   			|| Auth::user()->isBlogAdmin() 

   			)
   			{
   				return true;
   			}
   			return false;
   }
}
