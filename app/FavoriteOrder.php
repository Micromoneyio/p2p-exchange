<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteOrder extends Model
{
    protected $fillable = ['user_id', 'order_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
}
