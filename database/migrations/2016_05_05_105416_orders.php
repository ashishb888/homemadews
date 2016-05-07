<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Orders extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->increments('or_id');
                $table->integer('or_cust_id')->unsigned();
                $table->integer('or_menu_id')->unsigned();
                $table->double('or_total_price',10,2);
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
                $table->foreign('or_cust_id')->references('cu_id')->on('customer');  
                $table->foreign('or_menu_id')->references('me_id')->on('menu');
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
