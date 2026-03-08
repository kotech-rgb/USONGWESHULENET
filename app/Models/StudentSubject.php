<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSubject extends Model
{
  
  protected $fillable=[
    'subject_id',
    'class_id',
  ];  
}
