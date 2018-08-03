<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $fillable = ['deal_id','user_id','notes', 'viewed'];
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function deal()
    {
        return $this->belongsTo('App\Deal');
    }
}
