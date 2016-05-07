<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Customer extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(!Schema::hasTable('customer')) {
            Schema::create('customer', function (Blueprint $table) {
                $table->increments('cu_id');
                $table->string('cu_name',20);
                $table->string('cu_phone',20);
                $table->string('cu_password',50);
                $table->string('cu_email',100);
                $table->string('cu_cust_id',20);
                $table->timestamp('cu_last_logged_in');
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
