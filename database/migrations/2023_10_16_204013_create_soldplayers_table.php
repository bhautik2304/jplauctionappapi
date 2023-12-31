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
        Schema::create('soldplayers', function (Blueprint $table) {
            $table->id();
            // $table->unsignedBigInteger('no')->nullable();
            $table->unsignedBigInteger('players_no')->nullable();
            $table->unsignedBigInteger('players_id')->nullable();
            $table->unsignedBigInteger('teams_id')->nullable();
            $table->unsignedBigInteger('sold')->nullable();
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
        Schema::dropIfExists('soldplayers');
    }
};
