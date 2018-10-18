<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurchasedDetails extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purchased_details', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('parking_id');
            $table->integer('vehicle_id');
            $table->date('parking_date');
            $table->string('transaction_id');
            $table->float('amount')->default(0);
            $table->boolean('is_canceled')->default(0);
            $table->boolean('is_accepted')->nullable();
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
        //
    }
}
