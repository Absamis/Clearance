<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableStudents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('name', 30);
            $table->string('email', 40);
            $table->string('matric', 10);
            $table->string('department', 20);
            $table->string('level', 5);
            $table->string('phone', 13);
            $table->string('studentid', 30);
            $table->integer('status')->default(0);
            $table->string('session', 10);
            $table->text('remember_token')->nullable();
            $table->longText('password');
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
        Schema::dropIfExists('table_students');
    }
}
