<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DealHistory extends Model
{
    protected $fillable = ['deal_id','deal_stage_id','notes', 'bpm_id'];
    public function deal()
    {
        return $this->belongsTo('App\Deal');
    }

    public function deal_stage()
    {
        return $this->belongsTo('App\DealStage');
    }
}
