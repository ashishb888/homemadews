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
                $table->increments('id');
                $table->integer('dish_type_id')->unsigned();
                $table->string('name',20);
                $table->string('code',20);
                $table->double('price',10,2);
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
                $table->foreign('dish_type_id')->references('id')->on('dish_types');    
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
