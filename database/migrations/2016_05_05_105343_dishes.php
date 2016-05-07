<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Dishes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('dishes')) {
            Schema::create('dishes', function (Blueprint $table) {
                $table->increments('di_id');
                $table->integer('di_dish_type_id')->unsigned();
                $table->string('di_name',20);
                $table->string('di_code',20);
                $table->double('dt_price',10,2);
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
                $table->foreign('di_dish_type_id')->references('dt_id')->on('dish_types');    
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
