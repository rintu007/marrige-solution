<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Block extends Model
{
    protected $fillable = [
        'user_id',
        'user_second_id'
    ];
}
