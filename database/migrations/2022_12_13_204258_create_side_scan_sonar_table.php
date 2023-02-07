<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSideScanSonarTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('side_scan_sonar', function (Blueprint $table) {
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
            $table->string('location')->nullable();
            $table->string('area_to_scan')->nullable();
            $table->string('interval')->nullable();
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
        Schema::dropIfExists('side_scan_sonar');
    }
}
