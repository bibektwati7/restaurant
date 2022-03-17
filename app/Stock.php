<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Stock extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'food_id','total_quantity','remaining_quantity','from_date','to_date'
    ];
    public function food(){
        return $this->belongsTo(Food::class);
    }
    public function category(){
        return $this->belongsTo(Category::class);
    }
    // public function foods()
    // {
    //     return $this->belongsToMany(Food::class, 'food_stocks', 'food_id', 'stock_id')->withPivot('quantity');
    // }
}
