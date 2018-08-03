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
            'updated_at' => $this->updated_at
        ];
    }
}
