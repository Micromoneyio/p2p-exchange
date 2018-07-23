<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    protected $fillable = ['user_id','order_id','source_asset_id','destination_asset_id','source_value',
            'destination_value','deal_stage_id','transit_currency_id','transit_address','transit_key','transit_hash'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }
    
    public function get_address(string $symbol) {
        $currency = Currency::where(['symbol' => $symbol])->first();
        $this->transit_currency_id = $currency->id;
        $this->deal_stage_id = DealStage::where(['name' => 'Waiting for escrow'])->first()->id;

        $module = new CryptoModule($symbol);
        $response = $module->getAddress();

        $this->transit_address = $response->address;
        $this->transit_key = $response->privateKey;
    }
}
