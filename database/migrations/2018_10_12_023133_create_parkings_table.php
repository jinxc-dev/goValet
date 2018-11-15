<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParkingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parkings', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('name')->nullable();
            $table->string('t_name')->nullable();
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('country')->nullable();

            $table->integer('lot_type')->nullable();
            $table->string('image')->nullable();            
            $table->integer('status')->nullable();
            $table->float('latitude');
            $table->float('longitude');
            $table->string('address');
            $table->integer('capacity');
            $table->string('description')->nullable();
            $table->string('rate');
            $table->integer('availability')->nullable();
            $table->string('from_time')->nullable();
            $table->string('to_time')->nullable();
            $table->integer('cancellation_charges')->default(0);
            $table->string('s_prod_id')->nullable();
            $table->string('s_plan_id')->nullable();
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
        Schema::dropIfExists('parkings');
    }
}
