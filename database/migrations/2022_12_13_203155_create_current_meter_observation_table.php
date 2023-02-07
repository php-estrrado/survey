<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCurrentMeterObservationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('current_meter_observation', function (Blueprint $table) {
            $table->id();
            $table->integer('cust_id');
            $table->string('designation')->nullable();
            $table->string('sector')->nullable();
            $table->integer('department')->nullable();
            $table->string('firm')->nullable();
            $table->string('purpose')->nullable();
            $table->integer('service')->nullable();
            $table->string('description')->nullable();
            $table->integer('state')->nullable();
            $table->integer('district')->nullable();
            $table->string('place')->nullable();
            $table->string('type_of_waterbody')->nullable();
            $table->date('observation_start_date')->nullable();
            $table->date('observation_end_date')->nullable();
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
        Schema::dropIfExists('current_meter_observation');
    }
}
