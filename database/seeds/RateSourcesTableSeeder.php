<?php

use Illuminate\Database\Seeder;

class RateSourcesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\RateSource::create([
            'name'    => 'CoinMarketCap',
            'default' => true
        ]);
    }
}
