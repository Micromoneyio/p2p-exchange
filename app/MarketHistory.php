<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MarketHistory extends Model
{
    protected $fillable = ['currency_id', 'unit_currency_id','rate_source_id','market_cap','price'];
}
