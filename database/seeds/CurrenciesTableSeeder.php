<?php

use Illuminate\Database\Seeder;

class CurrenciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $currencies = [
            [ 'name' => 'Ethereum', 'symbol' => 'ETH', 'crypto' => true ],
            [ 'name' => 'Ruble',    'symbol' => 'RUB', 'crypto' => false ],
            [ 'name' => 'Dollar',   'symbol' => 'USD', 'crypto' => false ]
        ];

        foreach ($currencies as $currency) {
            \App\Currency::create([
                'name'   => $currency['name'],
                'symbol' => $currency['symbol'],
                'crypto' => $currency['crypto']
            ]);
        }
    }
}
