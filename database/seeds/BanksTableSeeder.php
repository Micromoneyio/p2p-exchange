<?php

use Illuminate\Database\Seeder;

class BanksTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $banks = ['Sberbank', 'Tinkoff'];

        foreach ($banks as $bank) {
            \App\Bank::create([
                'name' => $bank
            ]);
        }
    }
}
