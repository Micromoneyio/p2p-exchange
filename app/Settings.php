<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = ['user_id', 'local_currency_id'];

    /**
     * @param $userId
     * @return Settings
     */
    /**public static function forUser($userId)
    {
        $model = self::where('user_id', $userId)->first();
        if(!$model) {
            $defaultCurrency = Currency::where('name', 'Dollar')->first();
            $model = self::create([
                'user_id' => $userId,
                'local_currency_id' => $defaultCurrency->id,
            ]);
        }

        return $model;
    }

    public function local_currency()
    {
        return $this->belongsTo(Currency::class, 'local_currency_id');
    }
     * */
}
