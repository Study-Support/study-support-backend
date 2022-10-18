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
        Schema::create('user_information', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->string('full_name', 255)->nullable();
            $table->string('address', 100)->nullable();
            $table->string('phone_number')->nullable();
            $table->string('birthday')->nullable();
            $table->tinyInteger('rating');
            $table->unsignedInteger('class_id')->nullable()->comment('class id');
            $table->unsignedInteger('faculty_id')->nullable()->comment('faculty id');
            $table->boolean('gender')->nullable()->comment('0:female | 1:male');
            $table->string('avatar_url')->nullable();
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('class_id')->references('id')->on('classes');
            $table->foreign('faculty_id')->references('id')->on('faculties');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_information');
    }
};
