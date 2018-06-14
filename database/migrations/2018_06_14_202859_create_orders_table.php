<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('source_currency_id');
            $table->unsignedInteger('destination_currency_id');
            $table->unsignedInteger('source_asset_id');
            $table->unsignedInteger('destination_asset_id');
            $table->unsignedInteger('rate_source_id');
            $table->float('fix_price');
            $table->float('source_price_index');
            $table->float('limit_from');
            $table->float('limit_to');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('source_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('destination_currency_id')->references('id')->on('currencies')->onDelete('cascade');
            $table->foreign('source_asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('destination_asset_id')->references('id')->on('assets')->onDelete('cascade');
            $table->foreign('rate_source_id')->references('id')->on('rate_sources')->onDelete('cascade');
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
        Schema::dropIfExists('orders');
    }
}
