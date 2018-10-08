<?php

namespace App\Jobs;

use App\CryptoModule;
use App\Deal;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class CheckCanceledDeal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private $deal;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Deal $deal)
    {
        $this->deal = $deal;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $deal = $this->deal;
        $module = new CryptoModule($deal->getCryptoCurrency()->symbol);
        $response = $module->checkBalance($deal->transit_address);
        if ($response->balance > 0 && $deal->deal_stage()->get()->first()->name=='Cancelled'){
            $deal->returnEscrowToSeller($response->balance);
        }

    }
}
