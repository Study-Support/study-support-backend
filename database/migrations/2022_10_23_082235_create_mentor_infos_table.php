<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentor_information', function (Blueprint $table) {
            $table->integerIncrements('id');
            $table->unsignedBigInteger('account_id');
            $table->string('cv_link');
            $table->string('smart_banking');
            $table->boolean('active')->comment('0: no | 1: active');
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentor_information');
    }
};
