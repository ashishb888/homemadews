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
                $table->increments('ar_id');
                $table->integer('ar_city_id')->unsigned();
                $table->string('ar_name',20);
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
                $table->foreign('ar_city_id')->references('ct_id')->on('city'); 
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
