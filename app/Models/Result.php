<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Result extends Model
{
    protected $fillable=[
        'student_id',
        'term',
        'year',
        'class',
        'score_details',
        'average_score',
        'average_grade',
        'total_points',
        'division',
        'position',
        'sms',
    ];
}
