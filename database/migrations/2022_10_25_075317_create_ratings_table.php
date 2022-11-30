<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('rating');
            $table->text('comment')->nullable();
            $table->morphs('rateable');
            $table->unsignedBigInteger('account_id');
            $table->index('rateable_id');
            $table->index('rateable_type');
            $table->unsignedInteger('group_id');

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::drop('ratings');
    }
}
