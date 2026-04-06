<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsPackage extends Model
{
    protected $fillable = ['name', 'min_limit', 'max_limit', 'price_per_unit', 'badge_color'];
}