<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Callback extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function send(string $content)
    {
        $curl = curl_init($this->url);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, array("Content-type: application/json"));
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
        curl_exec($curl);
        curl_close($curl);
    }
}
