<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealStage extends Model
{
    protected $fillable = ['name', 'bpm_id'];

    public function deals() {
        return $this->hasMany('App\Deal');
    }

    public function dealHistories() {
        return $this->hasMany('App\DealHistory');
    }
}
