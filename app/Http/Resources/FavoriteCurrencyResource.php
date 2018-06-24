<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FavoriteCurrencyResource extends JsonResource
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
            'id'         => $this->id,
            'user'       => new UserResource($this->user),
            'currency'   => new CurrencyResource($this->currency),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
