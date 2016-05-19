<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Membership extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('membership')) {
            Schema::create('membership', function (Blueprint $table) {
                $table->increments('id');
                $table->string('type',20)->nullable();
                $table->string('description',200)->nullable();
                $table->integer('total_days')->nullable();
                $table->double('price',10,2)->nullable();
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
