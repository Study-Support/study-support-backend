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
    Schema::create('groups', function (Blueprint $table) {
      $table->integerIncrements('id');
      $table->string('topic');
      $table->string('information');
      $table->string('time_study');
      $table->string('location_study');
      $table->unsignedInteger('subject_id');
      $table->unsignedInteger('faculty_id');
      $table->boolean('self_study')->comment('0: control | 1: self_study');
      $table->tinyInteger('status')->comment('0: waiting | 1: find_member | 2: find_mentor | 3: studying | 4: close');
      $table->timestamps();

      $table->foreign('subject_id')->references('id')->on('subjects');
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
    Schema::dropIfExists('groups');
  }
};
