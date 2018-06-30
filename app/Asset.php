<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = ['name', 'asset_type_id', 'user_id', 'currency_id', 'address', 'bank_id'];


    public function assetType() {
        return $this->belongsTo('App\AssetType');
    }

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function currency() {
        return $this->belongsTo('App\Currency');
    }

    public function bank() {
        return $this->belongsTo('App\Bank');
    }

    public function crypto() {
        return Currency::find($this->currency_id)->crypto;
    }

    public function fiat() {
        return !Currency::find($this->currency_id)->crypto;
    }
}
