<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Admin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('admin')) {
            Schema::create('admin', function (Blueprint $table) {
                $table->increments('ad_id');
                $table->string('username',50);
                $table->string('password',250);
                $table->timestamp('last_logged_in')->nullable();
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
