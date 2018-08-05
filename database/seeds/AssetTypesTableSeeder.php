<?php

use Illuminate\Database\Seeder;

class AssetTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $asset_types = [
            [ 'name' => 'Credit card',     'crypto' => false ],
            [ 'name' => 'Bank account',    'crypto' => false ],
            [ 'name' => 'Crypto currency', 'crypto' => true ],
            [ 'name' => 'Token',           'crypto' => true ],
            [ 'name' => 'Personal deposit', 'crypto' => true ],
        ];

        foreach ($asset_types as $asset_type) {
            \App\AssetType::create([
                'name'   => $asset_type['name'],
                'crypto' => $asset_type['crypto']
            ]);
        }
    }
}
