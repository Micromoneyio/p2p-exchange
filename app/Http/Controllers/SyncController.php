<?php

namespace App\Http\Controllers;

use App\AssetType;
use App\Bank;
use App\DealStage;
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
}
