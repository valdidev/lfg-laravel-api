<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('party_user', function (Blueprint $table) {
            $table->id();

            $table->boolean('is_owner');
            $table->boolean('is_active');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('party_id');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('party_id')->references('id')->on('parties')->onDelete('cascade');

            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('party_user');
    }
};
