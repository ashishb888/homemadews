<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Areas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('area')) {
            Schema::create('area', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('city_id')->unsigned();
                $table->string('name',50)->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
                $table->foreign('city_id')->references('id')->on('city'); 
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
