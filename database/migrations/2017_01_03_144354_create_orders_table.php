<?php

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
            $table->integer('vehicle_id')->unsigned();
			$table->foreign('vehicle_id')
				  ->references('id')->on('vehicles')
				  ->onDelete('cascade');

            $table->integer('odometer')->nullable();
            $table->text('remarks')->nullable();
            $table->enum('status', ['Pendiente', 'Trabajando', 'Finalizada'])->default('Pendiente');
            $table->text('tasks')->nullable();
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
        Schema::drop('orders');
    }
}
