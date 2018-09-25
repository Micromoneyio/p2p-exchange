<?php

namespace App\Observers;

use App\Jobs\BpmRequestJob;
use App\Order;

class OrderObserver
{
    /**
     * Handle to the order "created" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function created(Order $order)
    {
        BpmRequestJob::dispatch($order->id, 'Order');
    }

    /**
     * Handle the order "updated" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function updated(Order $order)
    {
        BpmRequestJob::dispatch($order->id, 'Order');
    }

    /**
     * Handle the order "deleted" event.
     *
     * @param  \App\Order  $order
     * @return void
     */
    public function deleted(Order $order)
    {
        //
    }
}
