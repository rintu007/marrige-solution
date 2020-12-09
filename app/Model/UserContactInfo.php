<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class UserContactInfo extends Model
{
    protected $casts = [
        'checked' => 'boolean',
        'can_edit' => 'boolean',
    ];
}
