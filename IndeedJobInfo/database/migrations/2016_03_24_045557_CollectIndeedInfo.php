<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CollectIndeedInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('CompanyInfo', function (Blueprint $table) {
            $table->increments('CompanyId');
            $table->string('CompanyName');
            $table->string('City')->nullable();;
            $table->string('Province')->nullable();;
            $table->string('Link');
            $table->boolean('EasilyApply')->nullable();;
            $table->boolean('Sponsered')->nullable();;
            $table->date('AddedTime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('CompanyInfo');
    }
}
