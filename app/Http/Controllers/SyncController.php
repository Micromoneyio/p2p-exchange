<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetType;
use App\Bank;
use App\Currency;
use App\DealStage;
use App\Order;
use App\RateSource;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SyncController extends Controller
{
    public function bank(Request $request)
    {
        Log::info('Bank sync request', ['request' => $request]);
        if (getenv('BPM_TOKEN') != $request->token) {
            throw new \Exception('Invalid token');
        }
        $bank = Bank::where(['bpm_id' => $request->id])->first();
        if (empty($bank)) {
            $bank = new Bank(['bpm_id' => $request->id]);
        }
        $bank->name = $request->name;
        $bank->save();
        return $bank;
    }

    public function asset_type(Request $request)
    {
        Log::info('Asset type sync request', ['request' => $request]);
        if (getenv('BPM_TOKEN') != $request->token) {
            throw new \Exception('Invalid token');
        }
        $asset_type = AssetType::where(['bpm_id' => $request->id])->first();
        if (empty($asset_type)) {
            $asset_type = new AssetType(['bpm_id' => $request->id]);
        }
        $asset_type->name = $request->name;
        $asset_type->crypto = $request->crypto == '1';
        $asset_type->save();
        return $asset_type;
    }

    public function deal_stage(Request $request)
    {
        Log::info('Deal stage sync request', ['request' => $request]);
        if (getenv('BPM_TOKEN') != $request->token) {
            throw new \Exception('Invalid token');
        }
        $deal_stage = DealStage::where(['bpm_id' => $request->id])->first();
        if (empty($deal_stage)) {
            $deal_stage = new DealStage(['bpm_id' => $request->id]);
        }
        $deal_stage->name = $request->name;
        $deal_stage->save();
        return $deal_stage;
    }

    public function rate_source(Request $request)
    {
        Log::info('Rate source sync request', ['request' => $request]);
        if (getenv('BPM_TOKEN') != $request->token) {
            throw new \Exception('Invalid token');
        }
        $rate_source = RateSource::where(['bpm_id' => $request->id])->first();
        if (empty($rate_source)) {
            $rate_source = new RateSource(['bpm_id' => $request->id]);
        }
        $rate_source->name = $request->name;
        $rate_source->default = $request->default == '1';
        $rate_source->save();
        return $rate_source;
    }

    public function currency(Request $request)
    {
        Log::info('Currency sync request', ['request' => $request]);
        if (getenv('BPM_TOKEN') != $request->token) {
            throw new \Exception('Invalid token');
        }
        $currency = Currency::where(['bpm_id' => $request->id])->first();
        if (empty($currency)) {
            $currency = new Currency(['bpm_id' => $request->id]);
        }
        $currency->name = $request->name;
        $currency->symbol = $request->symbol;
        $currency->crypto = $request->crypto == '1';
        $currency->save();
        return $currency;
    }

    public function asset(Request $request)
    {
        Log::info('Asset sync request', ['request' => $request]);
        if (getenv('BPM_TOKEN') != $request->token) {
            throw new \Exception('Invalid token');
        }
        $asset = Asset::where(['bpm_id' => $request->id])->first();
        if (empty($asset)) {
            $asset = new Asset(['bpm_id' => $request->id]);
        }
        $asset->name = $request->name;
        $asset->default = $request->default == '1';
        $asset->notes = $request->notes;
        $asset->address = $request->address;

        $asset_type = AssetType::where(['bpm_id' => $request->asset_type])->first();
        $asset->asset_type_id = $asset_type->id;

        $user = User::where(['bpm_id' => $request->user])->first();
        $asset->user_id = $user->id;

        $currency = Currency::where(['bpm_id' => $request->currency])->first();
        $asset->currency_id = $currency->id;

        if (!empty($request->bank)) {
            $bank = Bank::where(['bpm_id' => $request->bank])->first();
            $asset->bank_id = $bank->id;
        }

        $asset->save();
        return $asset;
    }

    public function contact(Request $request)
    {
        Log::info('User sync request', ['request' => $request]);
        if (getenv('BPM_TOKEN') != $request->token) {
            throw new \Exception('Invalid token');
        }
        $user = User::where(['bpm_id' => $request->id])->first();
        if (empty($user)) {
            $user = new User(['bpm_id' => $request->id]);
        }

        $user->email = $request->email;
        $user->name = $request->name;
        $user->rank = $request->rank;
        $user->employee = $request->employee == '1';
        $user->is_verified = $request->is_verified == '1';
        $user->allow_unranked = $request->allow_unranked == '1';
        $user->sort = $request->sort;
        $user->min_rank = $request->min_rank;
        $user->deals_count = $request->deal_count;

        $currency = Currency::where(['bpm_id' => $request->default_currency])->first();
        $user->default_currency_id = $currency->id;

        $user->telegram = $request->telegram;

        $user->save();
        return $user;
    }

    public function order(Request $request)
    {
        Log::info('Order sync request', ['request' => $request]);
        if (getenv('BPM_TOKEN') != $request->token) {
            throw new \Exception('Invalid token');
        }
        $order = Order::where(['bpm_id' => $request->id])->first();
        if (empty($order)) {
            $order = new Order(['bpm_id' => $request->id]);
        }

        $order->name = $request->name;
        $order->fix_price = $request->fix_price;
        $order->source_price_index = $request->source_price_index;
        $order->limit_from = $request->limit_from;
        $order->limit_to = $request->limit_to;

        $user = User::where(['bpm_id' => $request->contact])->first();
        $order->user_id = $user->id;

        $source_currency = Currency::where(['bpm_id' => $request->source_currency])->first();
        $order->source_currency_id = $source_currency->id;
        $destination_currency = Currency::where(['bpm_id' => $request->destination_currency])->first();
        $order->destination_currency_id = $destination_currency->id;

        $source_asset = Asset::where(['bpm_id' => $request->source_asset])->first();
        $order->source_asset_id = $source_asset->id;
        $destination_asset = Asset::where(['bpm_id' => $request->destination_asset])->first();
        $order->destination_asset_id = $destination_asset->id;

        $rate_source = RateSource::where(['bpm_id' => $request->rate_source])->first();
        $order->rate_source_id = $rate_source->id;

        $order->save();
        return $order;
    }
}
