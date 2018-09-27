<?php

namespace App\Observers;

use App\Bank;
use App\Jobs\BpmRequestJob;

class BankObserver
{
    /**
     * Handle to the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Bank $bank)
    {
        BpmRequestJob::dispatch($bank->id, 'Bank');
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Bank $bank)
    {
        BpmRequestJob::dispatch($bank->id, 'Bank');
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Bank $bank)
    {
        //
    }
}
