<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSearchTerm extends Model
{
       protected $fillable = [

        'addedby_id',
        'editedby_id',
        'user_id',
    ];

    public function countryOfOrigin()
    {
    	if ( ($this->country == 'Other') or 
    		($this->country == 'Others') ) {

    		return $this->country_other;
    	}

    	return $this->country;
    }
}
