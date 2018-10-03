<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['name', 'bpm_id'];

    public function assets() {
        return $this->hasMany('App\Asset');
    }
}
