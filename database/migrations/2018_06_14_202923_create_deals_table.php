<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deals', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('order_id');
            $table->unsignedInteger('deal_stage_id');
            $table->unsignedInteger('source_asset_id');
            $table->unsignedInteger('destination_asset_id');
            $table->unsignedInteger('transit_currency_id');
            $table->string('transit_address');
            $table->string('transit_key');
            $table->string('transit_hash');
            $table->float('source_value');
            $table->float('destination_value');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->foreign('deal_stage_id')->references('id')->on('deal_stages')->onDelete('cascade');
            $table->foreign('source_asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('destination_asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('transit_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('deals');
    }
}
