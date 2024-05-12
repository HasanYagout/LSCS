<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->integer('student_id');
            $table->string('first_name');
            $table->string('middle_name');
            $table->string('last_name');
            $table->float('gpa');
            $table->string('major');
            $table->string('registration_year');
            $table->string('graduation_year');
            $table->integer('credits_left');
            $table->integer('number');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
