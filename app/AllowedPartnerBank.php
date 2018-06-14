<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AllowedPartnerBank extends Model
{
    protected $fillable = ['asset_id', 'bank_id'];

    public function bank() {
        return $this->belongsTo('App\Bank');
    }

    public function asset() {
        return $this->belongsTo('App\Asset');
    }
}
