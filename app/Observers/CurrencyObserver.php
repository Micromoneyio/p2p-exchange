<?php

namespace App\Observers;

use App\Currency;

class CurrencyObserver
{
    /**
     * Handle to the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Currency $currency)
    {
        BpmRequestJob::dispatch($currency->id, 'Currency');
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Currency $currency)
    {
        BpmRequestJob::dispatch($currency->id, 'Currency');
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Currency $currency)
    {
        //
    }
}
