<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'source_currency_id',
        'destination_currency_id',
        'rate_source_id',
        'source_asset_id',
        'destination_asset_id',
        'fix_price',
        'source_price_index',
        'limit_from',
        'limit_to'
    ];

    public function user() {
        return $this->belongsTo('App\User');
    }

    public function rate_source() {
        return $this->belongsTo('App\RateSource');
    }

    public function source_currency() {
        return $this->belongsTo('App\Currency', 'source_currency_id');
    }

    public function destination_currency() {
        return $this->belongsTo('App\Currency', 'destination_currency_id');
    }

    public function source_asset() {
        return $this->belongsTo('App\Asset', 'source_asset_id');
    }

    public function destination_asset() {
        return $this->belongsTo('App\Asset', 'destination_asset_id');
    }

    public function deals() {
        return $this->hasMany('App\Deal');
    }

    public function type() {
        if ($this->source_currency()->crypto && !$this->destination_currency->crypto) {
            return 'crypto_to_fiat';
        }
        else {
            return 'fiat_to_crypto';
        }
    }

    public function price() {
        $result = 0;
        if ($this->fix_price) {
            $result = $this->fix_price;
        }
        elseif ($this->source_price_index) {
            $history_params = [ 'rate_source_id' => $this->rate_source->id];
            switch ($this->type()) {
                case 'crypto_to_fiat':
                    $history_params['currency_id'] = $this->source_currency->id;
                    $history_params['unit_currency_id'] = $this->destination_currency->id;
                    break;
                case 'fiat_to_currency':
                    $history_params['currency_id'] = $this->destination_currency->id;
                    $history_params['unit_currency_id'] = $this->source_currency->id;
                    break;
            }
            $market_history = MarketHistory::orderBy('created_at', 'asc')->where($history_params)->first;
            if ($market_history != null) {
                $result = $market_history->price + ($market_history->price * $this->source_price_index / 100);
            }
        }
        return $result;
    }

    public function is_favorite()
    {
        if ($this->id == null) {
            return false;
        }
        return $this->user->favorite_orders->where('order_id', $this->id)->isNotEmpty();
    }
}
