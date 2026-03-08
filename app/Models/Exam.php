<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    protected $fillable=[
         'studentE',
         'subjectE',
         'classE',
         'test',
         'score',
         'termE',
         'yearE', 
    ];
}
