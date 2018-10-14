<?php

namespace App\Observers;

use App\DealHistory;
use App\Jobs\BpmRequestJob;

class DealHistoryObserver
{
    /**
     * Handle to the deal history "created" event.
     *
     * @param  \App\DealHistory  $dealHistory
     * @return void
     */
    public function created(DealHistory $dealHistory)
    {
        BpmRequestJob::dispatch($dealHistory->id, 'DealHistory');
    }

    /**
     * Handle the deal history "updated" event.
     *
     * @param  \App\DealHistory  $dealHistory
     * @return void
     */
    public function updated(DealHistory $dealHistory)
    {
        BpmRequestJob::dispatch($dealHistory->id, 'DealHistory');
    }

    /**
     * Handle the deal history "deleted" event.
     *
     * @param  \App\DealHistory  $dealHistory
     * @return void
     */
    public function deleted(DealHistory $dealHistory)
    {
        //
    }
}
