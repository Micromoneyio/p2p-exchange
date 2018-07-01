<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketHistory extends Model
{
    protected $fillable = ['currency_id', 'unit_currency_id','rate_source_id','market_cap','price'];



    public function currency()
    {
        return $this->belongsTo(Currency::class);
    }
    public function rate_source()
    {
        return $this->belongsTo(RateSource::class);
    }
    public function unit_currency()
    {
        return $this->hasOne(Currency::class,'id','unit_currency_id');
    }
}
