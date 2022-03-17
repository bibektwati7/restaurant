<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Setting extends Model
{
    protected $fillable = [
        'app_name', 'restaurant_address', 'restaurant_name', 'contact_number', 'restaurant_logo'
    ];
}
