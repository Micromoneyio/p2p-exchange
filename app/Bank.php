<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    protected $fillable = ['name'];

    public function assets() {
        return $this->hasMany('App\Asset');
    }
}
