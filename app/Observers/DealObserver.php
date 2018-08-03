<?php

namespace App\Observers;

use App\Deal;
use App\DealHistory;
use App\Jobs\SendCallbackJob;
use App\Notification;

class DealObserver
{
    /**
     * Handle to the deal "created" event.
     *
     * @param  \App\Deal  $deal
     * @return void
     */
    public function created(Deal $deal)
    {
        $deal->order->user->callbacks->where('event', 'deal.create')->each(function ($callback, $key) use ($deal) {
            SendCallbackJob::dispatch($callback, $deal->toJson());
        });
        Notification::create([
            'user_id' => $deal->order->user_id,
            'deal_id' => $deal->id,
            'text' => 'New deal created by one of your orders!',
            'viewed' => 0
        ]);
        Notification::create([
            'user_id' => $deal->order->type == 'crypto_to_fiat' ? $deal->order->user_id : $deal->user_id,
            'deal_id' => $deal->id,
            'text' => "Transfer crypto currency to " . $deal->transit_address,
            'viewed' => 0
        ]);
    }

    /**
     * Handle the deal "updated" event.
     *
     * @param  \App\Deal  $deal
     * @return void
     */
    public function updated(Deal $deal)
    {
        DealHistory::create([
            'deal_id' => $deal->id,
            'deal_stage_id' => $deal->deal_stage_id,
            'notes' => 'Deal update'
        ]);

        $notification_user_id = null;
        $notification_text    = null;

        switch ($deal->deal_stage->name) {
            case 'Escrow received':
                $notification_user_id = $deal->order->type == 'crypto_to_fiat' ? $deal->user_id : $deal->order->user_id;
                $notification_text = 'Escrow was successfully received!';
                break;
            case 'Marked as paid':
                $notification_user_id = $deal->order->type == 'crypto_to_fiat' ? $deal->order->user_id : $deal->user_id;
                $notification_text = 'Deal marked as paid!';
                break;
            case 'Escrow in releasing transaction':
                $notification_text = 'Order creator confirm payment, releasing escrow!';
                $notification_user_id = $deal->order->type == 'fiat_to_crypto' ? $deal->user_id : $deal->order->user_id;
                $deal->release_escrow();
                break;
        }
        if ($notification_user_id && $notification_text) {
            Notification::create([
                'user_id' => $notification_user_id,
                'deal_id' => $deal->id,
                'text' => $notification_text
            ]);
        }

        $deal->user->callbacks->where('event', 'deal.update')->each(function ($callback, $key) use ($deal) {
            SendCallbackJob::dispatch($callback, $deal->toJson());
        });
        $deal->order->user->callbacks->where('event', 'deal.update')->each(function ($callback, $key) use ($deal) {
            SendCallbackJob::dispatch($callback, $deal->toJson());
        });
    }

    /**
     * Handle the deal "deleted" event.
     *
     * @param  \App\Deal  $deal
     * @return void
     */
    public function deleted(Deal $deal)
    {
        //
    }
}
