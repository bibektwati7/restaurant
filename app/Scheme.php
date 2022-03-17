<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Scheme extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'food_id', 'quantity', 'status', 'start_date', 'end_date'
    ];
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
