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
        Schema::create('mentor_subject', function (Blueprint $table) {
            $table->unsignedInteger('mentor_id');
            $table->unsignedInteger('subject_id');
            $table->timestamps();

            $table->foreign('mentor_id')->references('id')->on('mentor_information');
            $table->foreign('subject_id')->references('id')->on('subjects');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentor_subject');
    }
};
