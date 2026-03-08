<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPayment extends Model
{
    protected $fillable = ['student_id','ac_year','mhula','payment_date','recorded_date','amount','method','reference','required_amount','payed_amount','received_by'];
}
