<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserPersonalInfo extends Model
{
    protected $casts = [

        'checked' => 'boolean',
        'can_edit' => 'boolean',
    ];

    public function educationLevel()
    {
    	if ( ($this->education_level == 'Other') or 
    		($this->education_level == 'Others') ) {

    		return $this->education_level_other;
    	}
    	
    	return $this->education_level;
    }

    public function profession()
    {
    	if ( ($this->my_profession == 'Other') or 
    		($this->my_profession == 'Others') ) {

    		return $this->my_profession_other;
    	}

    	return $this->my_profession;
    }

    public function citizen()
    {
    	if ( ($this->citizenship == 'Other') or 
    		($this->citizenship == 'Others') ) {

    		return $this->citizenship_other;
    	}

    	return $this->citizenship;
    }

    public function countryOfResidence()
    {
    	if ( ($this->country_of_residence == 'Other') or 
    		($this->country_of_residence == 'Others') ) {

    		return $this->country_of_residence_other;
    	}

    	return $this->country_of_residence;
    }

    
    public function hairColor()
    {
    	if ( ($this->hair_color == 'Other') or 
    		($this->hair_color == 'Others') ) {

    		return $this->hair_color_other;
    	}

    	return $this->hair_color;
    }
    
    public function eyeColor()
    {
    	if ( ($this->eye_color == 'Other') or 
    		($this->eye_color == 'Others') ) {

    		return $this->eye_color_other;
    	}

    	return $this->eye_color;
    }

    
    public function skinColor()
    {
    	if ( ($this->skin_color == 'Other') or 
    		($this->skin_color == 'Others') ) {

    		return $this->skin_color_other;
    	}

    	return $this->skin_color;
    }
    
    public function anyDisabilities()
    {
    	if ( ($this->disabilities_status == 'Other') or 
    		($this->disabilities_status == 'Others') ) {

    		return $this->disabilities_status_other;
    	}

    	return $this->disabilities_status;
    }




}
