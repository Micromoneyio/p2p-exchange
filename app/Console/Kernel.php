<?php

namespace App\Console;

use App\Currency;
use App\MarketHistory;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use React\Socket\ConnectionInterface;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
        $schedule->call(function(){
            $currencies = Currency::all();
            $crypto = $currencies->filter(function ($value){
               return  $value->crypto;
            });
            foreach ($crypto as $cryptoItem){
                foreach ($currencies as $item){
                    $result = json_decode(file_get_contents(getenv('API_URL') . strtolower($cryptoItem->name). '?convert='.$item->symbol),true);
                    MarketHistory::create([
                        'currency_id' => $cryptoItem->id,
                        'unit_currency_id' => $item->id,
                        'rate_source_id' => 1,
                        'market_cap' => $result[0]['market_cap_'.strtolower($item->symbol)],
                        'price' => $result[0]['price_'.strtolower($item->symbol)],
                    ]);
                }

            }
        })->everyMinute();
        $schedule->call(function (ConnectionInterface $connection){
            dd(get_class_methods($connection));
        })->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
