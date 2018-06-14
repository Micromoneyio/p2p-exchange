<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FavoriteCurrency extends Model
{
    protected $fillable = ['user_id', 'currency_id'];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function currency() {
        return $this->belongsTo('App\Currency');
    }
}
