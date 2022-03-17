<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FoodOrder extends Model
{
    use SoftDeletes;
    protected $table = 'food_order';
    protected $fillable = ['order_id', 'food_id', 'price', 'quantity', 'scheme'];
}
