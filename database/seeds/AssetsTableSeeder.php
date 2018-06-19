<?php

use Illuminate\Database\Seeder;

class AssetsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = \App\User::all();
        $credit_card_type = \App\AssetType::where('name', 'Credit card')->first();
        $crypto_type = \App\AssetType::where('name', 'Crypto currency')->first();
        $usd_currency = \App\Currency::where('symbol', 'USD')->first();
        $eth_currency = \App\Currency::where('symbol', 'ETH')->first();

        foreach ($users as $user) {
            \App\Asset::create([
                'name' => 'Credit card asset',
                'user_id' => $user->id,
                'asset_type_id' => $credit_card_type->id,
                'currency_id' => $usd_currency->id
            ]);

            \App\Asset::create([
                'name' => 'Crypto asset',
                'user_id' => $user->id,
                'asset_type_id' => $crypto_type->id,
                'currency_id' => $eth_currency->id
            ]);
        }
    }
}
