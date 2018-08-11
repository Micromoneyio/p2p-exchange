<?php

namespace App\Providers;

use App\Deal;
use App\Notification;
use App\Observers\DealObserver;
use App\Observers\NotificationObserver;
use App\Observers\OrderObserver;
use App\Observers\UserObserver;
use App\Order;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
        Deal::observe(DealObserver::class);
        User::observe(UserObserver::class);
        Order::observe(OrderObserver::class);
        Notification::observe(NotificationObserver::class);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    }
}
