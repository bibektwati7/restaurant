<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
        use SoftDeletes;

    protected $fillable = ['name','category_image'];
    public function foods()
    {
        return $this->hasMany(Food::class);
    }
    public function stock(){
        return $this->belongsTo(Stock::class);
    }
}
