<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class FrontSlider extends Model
{
    public function addedBy()
    {
        return $this->belongsTo('App\Model\User', 'addedby_id')->withoutGlobalScopes();
    }
}
