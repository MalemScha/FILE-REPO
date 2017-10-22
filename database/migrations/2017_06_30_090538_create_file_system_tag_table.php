<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileSystemTagTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_system_tag', function (Blueprint $table) {
            $table->increments('id');

            $table->unsignedInteger('file_system_id');
            $table->foreign('file_system_id')->references('id')->on('file_systems');

            $table->unsignedInteger('tag_id');
            $table->foreign('tag_id')->references('id')->on('tags');


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
        Schema::dropIfExists('file_system_tag');
    }
}
