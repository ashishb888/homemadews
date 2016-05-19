<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeliveryPerson extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('delivery_person')) {
            Schema::create('delivery_person', function (Blueprint $table) {
                $table->increments('id');
                $table->string('username',50);
                $table->string('password',250);
                $table->string('firstname',20);
                $table->string('lastname',20);
                $table->string('kyc_proof',5);
                $table->string('kyc_type',20);
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
