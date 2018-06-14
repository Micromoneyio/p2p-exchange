<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RateSource extends Model
{
    protected $fillable = ['name'];

    public function orders() {
        return $this->hasMany('App\Order');
    }

    public function market_histories() {
        return $this->hasMany('App\MarketHistory');
    }
}
