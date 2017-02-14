<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
      Schema::create('teams', function (Blueprint $table) {
          $table->increments('id');
          $table->string('team_key')->unique();
          $table->string('name');
          $table->string('logo');
          $table->integer('user_id')->unsigned();
          $table->integer('league_id')->unsigned();
          $table->integer('game_id')->unsigned();
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
        Schema::dropIfExists('teams');
    }
}
