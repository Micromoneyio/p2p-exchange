<?php

namespace App\Http\Controllers;

use App\Bank;
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
}
