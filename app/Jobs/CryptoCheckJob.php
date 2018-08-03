<?php

namespace App\Jobs;

use App\CryptoModule;
use App\Deal;
use App\DealStage;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CryptoCheckJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     * @param Deal $deal
     * @return void
     */
    public function handle(Deal $deal)
    {
//        $module = new CryptoModule($symbol);
//        $response = $module->checkBalance($deal->transit_address);
//        $expected = $deal->order->source_currency->crypto ? $deal->destination_value : $deal->source_value;
//
//        if ($response['balance'] == $expected) {
//            $dealStage = DealStage::where(['name' => 'Escrow received'])->first();
//            $deal->update(['deal_stage_id' => $dealStage->id]);
//        }
//        else {
//            CryptoCheckJob::dispatch($deal)->delay(now()->addSeconds(5));
//        }
    }
}
