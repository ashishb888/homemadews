<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CustomerMembership extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         if (!Schema::hasTable('customer_membership')) {
            Schema::create('customer_membership', function (Blueprint $table) {
                $table->increments('id');
                $table->integer('cust_id')->unsigned();
                $table->integer('member_id')->unsigned();
                $table->timestamp('valid_from');
                $table->timestamp('valid_to');
                $table->string('payment_type',20)->nullable();
                $table->integer('total_orders')->nullable();
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
                $table->foreign('cust_id')->references('id')->on('customer');  
                $table->foreign('member_id')->references('id')->on('membership');
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
