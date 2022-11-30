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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id');
            $table->unsignedInteger('group_id');
            $table->boolean('is_creator')->comment('0: member | 1: creator');
            $table->boolean('is_mentor')->comment('0: member | 1: mentor');
            $table->boolean('status')->comment('0: not_accepted | 1: accepted');
            $table->timestamps();

            $table->foreign('account_id')->references('id')->on('accounts');
            $table->foreign('group_id')->references('id')->on('groups');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('members');
    }
};
