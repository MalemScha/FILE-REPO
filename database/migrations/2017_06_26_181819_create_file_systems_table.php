<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileSystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_systems', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('folder_id');
            $table->unsignedInteger('department_folder_id');
            $table->unsignedInteger('department_id');
            $table->string('name');
            $table->text('description');
            $table->string('path');
            $table->string('size');
            $table->integer('isDepartmentFile')->default(0);
            $table->integer('isApproved')->default(0);
            $table->integer('isBoth')->default(0);
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
        Schema::dropIfExists('file_systems');
    }
}
