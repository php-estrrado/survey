<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustTelecomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cust_telecom', function (Blueprint $table) {
            $table->id();
            $table->integer('cust_id');
            $table->enum('telecom_type', array('1','2'));
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->integer('is_active')->default('1');
            $table->integer('is_deleted')->default('0');
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cust_telecom');
    }
}
