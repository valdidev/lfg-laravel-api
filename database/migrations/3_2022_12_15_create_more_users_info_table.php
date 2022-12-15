<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('more_users_info', function (Blueprint $table) {
            $table->id();
            $table->string('surname', 50);
            $table->integer('age');
            $table->string('steam_account')->nullable();
            $table->unsignedBigInteger('user_id');


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('more_users_info');
    }
};
