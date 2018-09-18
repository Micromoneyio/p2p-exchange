<?php

namespace App\Events;

use App\Http\Resources\AssetResource;
use App\Http\Resources\CurrencyResource;
use App\Http\Resources\DealStageResource;
use App\Http\Resources\OrderResource;
use App\Http\Resources\UserResource;
use App\Notification;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class SendNotification implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    /** @var  Notification */
    private $notification;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Notification $notification)
    {
        $this->notification = $notification;
        info('notification event: '.json_encode($notification));
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['notifications'];
    }

    public function broadcastWith()
    {
//        $this->notification->load('deal');
        return array_merge([
            'deal' => [
                'id' => $this->notification->deal->id,
                'user' => $this->notification->deal->user,
                'order' => $this->notification->deal->order,
                'deal_stage' => $this->notification->deal->deal_stage,
                'source_asset' => $this->notification->deal->source_asset,
                'destination_asset' => $this->notification->deal->destination_asset,
                'transit_currency' => $this->notification->deal->transit_currency,
                'transit_address' => $this->notification->deal->transit_address,
                'transit_hash' => $this->notification->deal->transit_hash,
                'source_value' => $this->notification->deal->source_value,
                'destination_value' => $this->notification->deal->destination_value,
                'created_at' => $this->notification->deal->created_at,
                'updated_at' => $this->notification->deal->updated_at,
                'destination_currency' => $this->notification->deal->destination_currency,
            ],
            'notification' => $this->notification->toArray(),
        ]);
    }

    public function broadcastAs()
    {
        return 'notification';
    }
}
