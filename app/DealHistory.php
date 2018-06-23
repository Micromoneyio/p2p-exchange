<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealHistory extends Model
{
    public function deal()
    {
        return $this->belongsTo('App\Deal');
    }
}
