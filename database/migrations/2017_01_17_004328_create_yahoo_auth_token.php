<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateYahooAuthToken extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('yahoo_tokens', function (Blueprint $table) {
            $table->increments('id');
            $table->text('access_token');
            $table->string('token_type');
            $table->string('expires_in');
            $table->integer('user_id');
            $table->timestamps();
        });

        // @todo add foreign keys
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('yahoo_tokens');
    }
}
