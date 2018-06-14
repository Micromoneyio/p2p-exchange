<?php

namespace App\Providers;

use App\Asset;
use Illuminate\Support\ServiceProvider;

class ProviderAsset extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        Asset::creating(function($model){
            Asset::where('user_id', $model->user_id)
                ->where('currency_id', $model->currency_id)
                ->update('default', false);
        });
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
