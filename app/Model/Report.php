<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    public function reportBy()
    {
        return $this->belongsTo('App\Model\User', 'user_id')->withoutGlobalScopes();
    }

    public function reportAbout()
    {
        return $this->belongsTo('App\Model\User', 'user_second_id')->withoutGlobalScopes();
    }
}
