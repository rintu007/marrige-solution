<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserPersonalActivity extends Model
{
    protected $casts = [

        'checked' => 'boolean',
        'can_edit' => 'boolean',

    ];
}
