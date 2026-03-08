<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    public $primaryKey = 'year_name'; // Use year_name as primary key
    public $incrementing = false;     // Not auto-incrementing
    protected $keyType = 'string';    // Since year_name is a string
    
    protected $fillable=['year_name','status'];
}
