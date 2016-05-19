<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OrderDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('order_detail')) {
            Schema::create('order_detail', function (Blueprint $table) {
                $table->increments('order_id');
                $table->integer('dish_id')->unsigned();
                $table->integer('order_quantity')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
                $table->foreign('dish_id')->references('id')->on('dishes');
            });
    
        }
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
