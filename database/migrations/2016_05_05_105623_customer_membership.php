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
                $table->increments('cm_id');
                $table->integer('cm_cust_id')->unsigned();
                $table->integer('cm_member_id')->unsigned();
                $table->timestamp('cm_valid_from');
                $table->timestamp('cm_valid_to');
                $table->string('cm_payment_type',20);
                $table->integer('cm_total_orders');
                $table->timestamps();
                $table->softDeletes();
                $table->engine = 'InnoDB';
                $table->foreign('cm_cust_id')->references('cu_id')->on('customer');  
                $table->foreign('cm_member_id')->references('me_id')->on('membership');
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
