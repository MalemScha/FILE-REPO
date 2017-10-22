<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileSystemUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_system_users', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('file_system_id');
            $table->foreign('file_system_id')->references('id')->on('file_systems');

            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');


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
        Schema::dropIfExists('file_system_users');//
    }
}
