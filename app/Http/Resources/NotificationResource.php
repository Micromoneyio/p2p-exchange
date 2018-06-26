<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationResource extends JsonResource
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
            'deal' => new DealResource($this->deal),
            'notes' => $this->notes,
            'viewed' => $this->viewed,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
