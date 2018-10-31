<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFieldsToDeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('deals', function (Blueprint $table) {
            $table->integer('escrow_received_user_id')->nullable();
            $table->integer('arbitrage_user_id')->nullable();
            $table->text('side_wallet')->nullable();
            $table->tinyInteger('request_cancel_by_buyer')->nullable();
            $table->tinyInteger('request_cancel_by_seller')->nullable();

        });

        Schema::table('settings', function (Blueprint $table) {
            $table->text('key')->nullable();
            $table->text('value')->nullable();
        });

        DB::table('settings')->insert(
            array(
                'value' => 'DEAL_CHECK_AFTER_CANCEL',
                'key' => 3600 // 1 hour
            )
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
}
