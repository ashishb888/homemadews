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
                $table->increments('od_order_id');
                $table->integer('od_dish_id')->unsigned();
                $table->integer('od_order_quantity');
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
                $table->foreign('od_dish_id')->references('di_id')->on('dishes');
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
