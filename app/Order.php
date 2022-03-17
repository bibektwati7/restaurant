<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
        use SoftDeletes;

    protected $fillable = ['user_id', 'sub_total', 'grand_total', 'token_no', 'scheme', 'status','table_id','payment','paid_amount'];

    public function foods()
    {
        return $this->belongsToMany('App\Food')->withPivot('quantity', 'price', 'scheme');
    }
    public function orderFoods()
    {
        return $this->hasMany(FoodOrder::class, 'order_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo('App\User');
    }
    // public function table()
    // {
    //     // dd($this->belongsTo('App\Table'));
    //     return $this->belongsTo('App\Table');
    // }
}
