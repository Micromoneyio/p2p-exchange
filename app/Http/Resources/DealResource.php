<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DealResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'order' => new OrderResource($this->order),
            'deal_stage' => new DealStageResource($this->deal_stage),
            'source_asset' => new AssetResource($this->source_asset),
            'destination_asset' => new AssetResource($this->destination_asset),
            'transit_currency' => new CurrencyResource($this->transit_currency),
            'transit_address' => $this->transit_address,
            'transit_hash' => $this->transit_hash,
            'source_value' => $this->source_value,
            'destination_value' => $this->destination_value,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'destination_currency' => new CurrencyResource($this->destination_currency),
            'outgoing_transaction_hash' => $this->outgoing_transaction_hash,
            'request_cancel_by_buyer' => $this->request_cancel_by_buyer,
            'request_cancel_by_seller' => $this->request_cancel_by_seller,
            'is_seller' => $this->is_seller,
        ];
    }
}
