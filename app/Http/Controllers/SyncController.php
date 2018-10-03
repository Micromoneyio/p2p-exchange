<?php

namespace App\Http\Controllers;

use App\Bank;
use Illuminate\Http\Request;

class SyncController extends Controller
{
    public function __construct(Request $request)
    {
        $this->beforeFilter(function() use ($request)
        {
            if (env('BPM_TOKEN') != $request->token) {
                throw new \Exception('Invalid token');
            }
        });
    }

    public function bank(Request $request)
    {
        $bank = Bank::where(['bpm_id' => $request->id])->first();
        if (empty($bank)) {
            $bank = new Bank(['bpm_id' => $request->id]);
        }
        $bank->update([
            'name' => $request->name
        ]);
    }
}
