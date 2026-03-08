<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
     protected $fillable=[
        'school_name',
        'box',
        'location',
        'school_reg',
        'open_school',
        'close_school',
        'headmaster_name',
        'sms_temp',
        'report_head'
     ];
}
