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
//        def get_address(symbol)
//            currency = Currency.find_by(symbol: symbol)
//            self.transit_currency = currency
//            self.deal_stage = DealStage.find_by(name: 'Waiting for escrow')
//
//            response = CryptoModule.new(symbol: symbol).get_address
//
//            self.transit_address = response['address']
//            self.transit_key     = response['privateKey']
//          end

    }
}
