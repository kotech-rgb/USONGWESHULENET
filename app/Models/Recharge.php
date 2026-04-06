<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recharge extends Model
{
   protected $fillable = [
        'invoice',
        'reference',
        'status',
        'SMS_amount',
        'pay_amount',
        'phone_number',
        'company_info'
    ];
}
