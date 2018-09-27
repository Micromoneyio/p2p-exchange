<?php

namespace App\Observers;

use App\RateSource;
use App\Jobs\BpmRequestJob;

class RateSourceObserver
{
    /**
     * Handle to the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(RateSource $rateSource)
    {
        BpmRequestJob::dispatch($rateSource->id, 'RateSource');
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(RateSource $rateSource)
    {
        BpmRequestJob::dispatch($rateSource->id, 'RateSource');
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(RateSource $rateSource)
    {
        //
    }
}
