<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssetType extends Model
{
    const TYPE_PERSONAL_DEPOSIT = 'Personal deposit';

    protected $fillable = ['name','crypto'];

    public function assets() {
        return $this->hasMany('App\Asset');
    }

    public function isPersonalDeposit()
    {
        return $this->name === self::TYPE_PERSONAL_DEPOSIT;
    }
}
