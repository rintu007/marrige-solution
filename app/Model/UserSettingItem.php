<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserSettingItem extends Model
{
    public function field()
    {
        return $this->belongsTo('App\Model\UserSettingField');
    }
}
