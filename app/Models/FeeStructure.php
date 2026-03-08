<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeeStructure extends Model
{

    protected $fillable = ['class_id','academic_year','amount','term_id','maelezo'];
}
