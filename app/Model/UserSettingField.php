<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSettingField extends Model
{
    protected $table = 'user_setting_fields';
    public function values()
    {
    	return $this->hasMany('App\Model\UserSettingItem', 'field_id');
    }

    public function hasValue()
    {
        if ($this->values->count()) {
            return true;
        }
        return false;
    }
}
