<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
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
            'source_currency' => new CurrencyResource($this->source_currency),
            'destination_currency' => new CurrencyResource($this->destination_currency),
            'source_asset' => new AssetResource($this->source_asset),
            'destination_asset' => new AssetResource($this->destination_asset),
            'rate_source' => new RateSourceResource($this->rate_source),
            'fix_price' => $this->fix_price,
            'source_price_index' => $this->source_price_index,
            'limit_from' => $this->limit_from,
            'limit_to' => $this->limit_to,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
