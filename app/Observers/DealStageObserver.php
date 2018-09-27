<?php

namespace App\Observers;

use App\DealStage;
use App\Jobs\BpmRequestJob;

class DealStageObserver
{
    /**
     * Handle to the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(DealStage $dealStage)
    {
        BpmRequestJob::dispatch($dealStage->id, 'DealStage');
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(DealStage $dealStage)
    {
        BpmRequestJob::dispatch($dealStage->id, 'DealStage');
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(DealStage $dealStage)
    {
        //
    }
}
