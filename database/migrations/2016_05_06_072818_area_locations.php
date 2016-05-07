<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AreaLocations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       if (!Schema::hasTable('area_location')) {
            Schema::create('area_location', function (Blueprint $table) {
                $table->increments('al_id');
                $table->integer('al_location_id')->unsigned();
                $table->string('al_name',20);
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
                $table->foreign('al_location_id')->references('ar_id')->on('area'); 
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
