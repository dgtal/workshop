<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVehiclesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('model_id')->unsigned();
			$table->foreign('model_id')
				  ->references('id')->on('models')
				  ->onDelete('cascade');

            $table->integer('customer_id')->unsigned();
			$table->foreign('customer_id')
				  ->references('id')->on('customers')
				  ->onDelete('cascade');

            $table->string('plate', 10);
            $table->string('vin', 20)->nullable();
            $table->unsignedSmallInteger('year')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('vehicles');
    }
}
