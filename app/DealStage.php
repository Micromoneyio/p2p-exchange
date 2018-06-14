<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealStage extends Model
{
    protected $fillable = ['name'];

    public function deals() {
        return $this->hasMany('App\Deal');
    }

    public function deal_histories() {
        return $this->hasMany('App\DealHistory');
    }
}
