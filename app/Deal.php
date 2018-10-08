<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Deal extends Model
{
    const STAGES = [
        'Waiting for escrow'    => '1',
        'Escrow in transaction' => '2',
        'Escrow received'       => '3',
        'Marked as paid'        => '4',
        'Escrow in releasing transaction' => '5',
        'Closed'                => '6',
        'Dispute opened'        => '7',
        'Cancelling'            => '8',
        'Cancelled'             => '9',
    ];
    protected $fillable = [
        'user_id',
        'order_id',
        'source_asset_id',
        'destination_asset_id',
        'source_value',
        'destination_value',
        'deal_stage_id',
        'transit_currency_id',
        'transit_address',
        'transit_key',
        'transit_hash',
        'outgoing_transaction_hash',
        'bpm_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function deal_stage()
    {

        return $this->belongsTo('App\DealStage');
    }

    public function source_asset()
    {
        return $this->belongsTo('App\Asset', 'source_asset_id');
    }

    public function destination_asset()
    {
        return $this->belongsTo('App\Asset', 'destination_asset_id');
    }

    public function order()
    {
        return $this->belongsTo('App\Order');
    }

    public function transit_currency()
    {
        return $this->belongsTo(Currency::class);
    }

    public function get_address(string $symbol)
    {
        $currency = Currency::where(['symbol' => $symbol])->first();
        $this->transit_currency_id = $currency->id;
        $this->deal_stage_id = DealStage::where(['name' => 'Waiting for escrow'])->first()->id;

        $module = new CryptoModule($symbol);
        $response = $module->getAddress();

        $this->transit_address = $response->address;
        $this->transit_key = $response->privateKey;
    }

    public function release_escrow($user_id = null, $override_address = null, $override_deal_stage_id = null)
    {
        if ($this->order->type == 'fiat_to_crypto') {
            $crypto_address = $this->destination_asset->address;
            $symbol = $this->destination_asset->currency->symbol;
            $crypto_value = $this->source_value;
        } else {
            $crypto_address = $this->source_asset->address;
            $symbol = $this->source_asset->currency->symbol;
            $crypto_value = $this->destination_value;
        }

        if ($override_address) {
            $crypto_address = $override_address;
        }

        if ($override_deal_stage_id) {
            $dealStage = $override_deal_stage_id;
        } else {
            $dealStage = DealStage::where(['name' => 'Closed'])->first()->id;
        }

        $module = new CryptoModule($symbol);
        $response = $module->releaseTransaction($this->transit_address, $this->transit_key, $crypto_address, $crypto_value);
        $this->update([
            'deal_stage_id' => $dealStage,
            'transit_hash' => $response->hash
        ]);
    }

    /**
     * @return Currency
     */
    public function getCryptoCurrency()
    {
        $sourceAsset = $this->source_asset;
        if ($sourceAsset != null) {
            $sourceCurrency = $this->source_asset->currency;
            $destinationCurrency = $this->destination_asset->currency;
            if ($sourceCurrency->crypto) {
                return $sourceCurrency;
            }
            if ($destinationCurrency->crypto) {
                return $destinationCurrency;
            }
        }
        return null;
    }

    public function returnEscrowToSeller($amount)
    {
        if ($this->order->type == 'fiat_to_crypto') {
            $crypto_address = $this->source_asset->address;
            $symbol = $this->source_asset->currency->symbol;
        } else {
            $crypto_address = $this->destination_asset->address;
            $symbol = $this->destination_asset->currency->symbol;
        }

        $module = new CryptoModule($symbol);
        $response = $module->releaseTransaction($this->transit_address, $this->transit_key, $crypto_address, $amount);
        $this->update([
            'deal_stage_id' => self::STAGES['Cancelled'],
            'transit_hash' => $response->hash
        ]);
        return true;
    }
}
