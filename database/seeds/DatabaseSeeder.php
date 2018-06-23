<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(CurrenciesTableSeeder::class);
         $this->call(AssetTypesTableSeeder::class);
         $this->call(RateSourcesTableSeeder::class);
         $this->call(BanksTableSeeder::class);
         $this->call(DealStagesTableSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(AssetsTableSeeder::class);
    }
}
