<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = ['name', 'symbol'];

    public function favorite(User $user) {
        if ($this->created_at == null) {
            return false;
        }
        $user->favorite_currencies->where('currency_id', $this->id)->exists();
    }

    public function market_cap(User $user) {
        if ($this->created_at == null) {
            return 0;
        }
        $rate_source = RateSource::where('default', true)->first();
        $history = MarketHistory::where('rate_source_id', $rate_source->id)
            ->where('currency_id', $this->id)
            ->where('unit_currency_id', $user->default_currency_id)
            ->first();

        if ($history == null) {
            return 0;
        }
        else {
            return $history->market_cap;
        }
    }
}
