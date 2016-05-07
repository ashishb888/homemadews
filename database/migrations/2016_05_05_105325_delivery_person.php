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
                $table->increments('dp_id');
                $table->string('dp_username',20);
                $table->string('dp_password',50);
                $table->string('dp_firstname',20);
                $table->string('dp_lastname',20);
                $table->string('dp_kyc_proof',5);
                $table->string('dp_kyc_type',20);
                $table->timestamp('dp_last_logged_in');
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
