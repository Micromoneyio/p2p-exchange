<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AssetResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $res = [
            'id' => $this->id,
            'user' => new UserResource($this->user),
            'asset_type' => new AssetTypeResource($this->asset_type),
            'currency' => new CurrencyResource($this->currency),
            'bank' => $this->bank ? new BankResource($this->bank) : null,
            'name' => $this->name,
            'address' => $this->address,
            'notes' => $this->notes,
            'default' => (bool)$this->default,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];

        if($this->asset_type->isPersonalDeposit()) {
            unset($res['key']);
        }

        return $res;
    }
}
