<?php

namespace App\Observers;

use App\Deal;
use App\DealHistory;
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
        //
    }

    /**
     * Handle the deal "updated" event.
     *
     * @param  \App\Deal  $deal
     * @return void
     */
    public function updated(Deal $deal)
    {
        //  def create_history
        //    DealHistory.create(deal_id: id, deal_stage: deal_stage)
        //
        //    case deal_stage.name
        //    when 'Waiting for escrow'
        //      Notification.create(user: order.user, deal_id: id, text: 'New deal created by one of your orders!')
        //      notification_user_id = order.type == :crypto_to_fiat ? order.user_id : user_id
        //      notification_text = "Transfer crypto currency to #{transit_address}"
        //    when 'Escrow received'
        //      notification_user_id = order.type == :crypto_to_fiat ? user_id : order.user_id
        //      notification_text = 'Escrow was successfully received!'
        //    when 'Marked as paid'
        //      notification_user_id = order.type == :crypto_to_fiat ? order.user_id : user_id
        //      notification_text = 'Deal marked as paid!'
        //    when 'Escrow in releasing transaction'
        //      notification_text = 'Order creator confirm payment, releasing escrow!'
        //      notification_user_id = order.type == :fiat_to_crypto ? user_id : order.user_id
        //      ReleaseEscrowWorker.perform_async(id)
        //    else
        //      Notification.create(user_id: user_id, deal_id: id, text: 'Unhandled status!')
        //      Notification.create(user_id: order.user_id, deal_id: id, text: 'Unhandled status!')
        //      return
        //          end
        //
        //    Notification.create(user_id: notification_user_id, deal_id: id, text: notification_text)
        //  end
        DealHistory::create([
            'deal_id' => $deal->id,
            'deal_stage_id' => $deal->deal_stage_id
        ]);

        switch ($deal->deal_stage->name) {
            case 'Waiting for escrow':
                Notification::create([
                    'user_id' => $deal->order->user_id,
                    'deal_id' => $deal->id,
                    'text' => 'New deal created by one of your orders!'
                ]);
                $notification_user_id = $deal->order->type == 'crypto_to_fiat' ? $deal->order->user_id : $deal->user_id;
                $notification_text = "Transfer crypto currency to " . $deal->transit_address;
                break;
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
        Notification::create([
            'user_id' => $notification_user_id,
            'deal_id' => $deal->id,
            'text' => $notification_text
        ]);
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
