<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Cities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('city')) {
            Schema::create('city', function (Blueprint $table) {
                $table->increments('ct_id');
                $table->string('ct_name',20);
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
