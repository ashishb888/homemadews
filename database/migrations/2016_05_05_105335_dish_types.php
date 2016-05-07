<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DishTypes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('dish_types')) {
            Schema::create('dish_types', function (Blueprint $table) {
                $table->increments('dt_id');
                $table->string('dt_name',20);
                $table->string('dt_code',20);
                $table->string('dt_type',20);
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';            
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
