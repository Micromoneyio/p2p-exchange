<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 0 ; $i < 3; $i++) {
            \App\User::create([
                'email' => "test${i}@test.test",
                'password' => 'test123',
                'name' => 'Firstname Lastname',
                'default_currency_id' => \App\Currency::where('symbol', 'USD')->first()->id
            ]);
        }
    }
}
