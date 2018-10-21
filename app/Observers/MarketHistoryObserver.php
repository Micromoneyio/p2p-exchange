<?php

namespace App\Observers;

use App\Jobs\BpmRequestJob;
use App\MarketHistory;

class MarketHistoryObserver
{
    /**
     * Handle to the market history "created" event.
     *
     * @param  \App\MarketHistory  $marketHistory
     * @return void
     */
    public function created(MarketHistory $marketHistory)
    {
        BpmRequestJob::dispatch($marketHistory->id, 'MarketHistory');
    }

    /**
     * Handle the market history "updated" event.
     *
     * @param  \App\MarketHistory  $marketHistory
     * @return void
     */
    public function updated(MarketHistory $marketHistory)
    {
        BpmRequestJob::dispatch($marketHistory->id, 'MarketHistory');
    }

    /**
     * Handle the market history "deleted" event.
     *
     * @param  \App\MarketHistory  $marketHistory
     * @return void
     */
    public function deleted(MarketHistory $marketHistory)
    {
        //
    }
}
