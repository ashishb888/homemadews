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
                $table->increments('me_id');
                $table->string('me_type',20);
                $table->string('me_description',200);
                $table->integer('me_total_days');
                $table->double('me_price',10,2);
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
