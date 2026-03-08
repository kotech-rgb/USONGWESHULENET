<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maombi extends Model
{
    protected $fillable=[
        'student_id',
        'staff_id',
        'request_type',
        'reason',
        'change_from',
        'change_to',
        'requested_by'
    ];
}
