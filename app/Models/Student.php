<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable=[
        'index_number',
        'firstname',
        'middlename',
        'lastname',
        'gender',
        'email',
        'phone',
        'class_name',
        'status',
    ];
}
