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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');

            $table->string('Course_name');
            $table->string('Duration');
            $table->string('Price');
            $table->string('study_mode');
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->string('course_provider');
            $table->string('email');
            $table->string('phone');

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
