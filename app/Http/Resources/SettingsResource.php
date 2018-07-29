<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SettingsResource extends JsonResource
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
            'user_id' => $this->user_id,
            'local_currency_id' => $this->local_currency_id,
            'local_currency' => new CurrencyResource($this->local_currency),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
