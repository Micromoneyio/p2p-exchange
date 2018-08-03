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
    private $deal;
    public function __construct(Deal $deal)
    {
        $this->deal = $deal;
    }

    /**
     * Execute the job.
     * @param int $dealId
     * @return void
     */
    public function handle()
    {
        $deal = $this->deal;
        $module = new CryptoModule($deal->getCryptoCurrency()->symbol);
        $response = $module->checkBalance($deal->transit_address);
        $expected = $deal->order->getTypeAttribute() == 'fiat_to_crypto' ? $deal->source_value : $deal->destination_value;

        if ($response->balance == $expected) {
            $dealStage = DealStage::where(['name' => 'Escrow received'])->first();
            $deal->update(['deal_stage_id' => $dealStage->id]);
        }
        else {
            CryptoCheckJob::dispatch($deal)->delay(now()->addSeconds(5));
        }
    }
}
