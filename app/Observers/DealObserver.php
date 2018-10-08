<?php

namespace App\Observers;

use App\Deal;
use App\DealHistory;
use App\Jobs\CheckCanceledDeal;
use App\Jobs\SendCallbackJob;
use App\Notification;
use App\Jobs\BpmRequestJob;
use App\Settings;

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
        BpmRequestJob::dispatch($deal->id, 'Deal');
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
                $deal->update(['request_cancel_by_seller' => 0]);
                break;
            case 'Escrow in releasing transaction':
                $notification_text = 'Order creator confirm payment, releasing escrow!';
                $notification_user_id = $deal->order->type == 'fiat_to_crypto' ? $deal->user_id : $deal->order->user_id;
                $deal->update(['request_cancel_by_seller' => 0]);
                $deal->release_escrow();
                break;
            case 'Cancelled':
                $delay = Settings::where('key','=','DEAL_CHECK_AFTER_CANCEL')->get()->first();
                if ($delay){
                    $delay = $delay->value;
                }else{
                    $delay = 3600;
                }
                CheckCanceledDeal::dispatch($deal)->delay($delay);
        }
        if ($notification_user_id && $notification_text) {
            Notification::create([
                'user_id' => $notification_user_id,
                'deal_id' => $deal->id,
                'text'    => $notification_text,
                'viewed'  => 0
            ]);
        }

        $deal->user->callbacks->where('event', 'deal.update')->each(function ($callback, $key) use ($deal) {
            SendCallbackJob::dispatch($callback, $deal->toJson());
        });
        $deal->order->user->callbacks->where('event', 'deal.update')->each(function ($callback, $key) use ($deal) {
            SendCallbackJob::dispatch($callback, $deal->toJson());
        });
        BpmRequestJob::dispatch($deal->id, 'Deal');
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
