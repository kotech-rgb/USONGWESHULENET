<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Division extends Model
{

    protected $fillable=[
        'div_name',
        'start_point',
        'end_point',
        'level',
    ];
}
