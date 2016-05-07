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
                $table->string('ad_username',20);
                $table->string('ad_password',50);
                $table->timestamp('ad_last_logged_in');
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
