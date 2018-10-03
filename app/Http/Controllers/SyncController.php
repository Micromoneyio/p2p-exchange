<?php

namespace App\Http\Controllers;

use App\Asset;
use App\AssetType;
use App\Bank;
use App\Currency;
use App\DealStage;
use App\RateSource;
use App\User;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    public function bank(Request $request)
    {
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

    public function asset(Request $request)
    {
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
}
