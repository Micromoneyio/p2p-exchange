<?php

use Illuminate\Database\Seeder;

class DealStagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $deal_stages = [
            'Waiting for escrow',
            'Escrow in transaction',
            'Escrow received',
            'Marked as paid',
            'Escrow in releasing transaction',
            'Closed',
            'Dispute opened',
            'Cancelling',
            'Cancelled'
        ];

        foreach ($deal_stages as $deal_stage) {
            \App\DealStage::create([
                'name' => $deal_stage
            ]);
        }
    }
}
