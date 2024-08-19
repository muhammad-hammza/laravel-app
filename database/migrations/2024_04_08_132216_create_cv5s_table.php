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
        Schema::create('cv5s', function (Blueprint $table) {
            $table->id();

            //properties
            $table->string('color')->nullable();
            $table->string('font')->nullable();
            $table->string('font_size')->nullable();
            $table->string('line_height')->nullable();

            $table->integer('user_id')->nullable();
            //profile
            $table->text('profile_image')->nullable();
            $table->text('profile_name')->nullable();
            $table->text('profile_description')->nullable();
            //education
            $table->text('education_scholl')->nullable();
            $table->text('education_city')->nullable();
            $table->text('education_start_date')->nullable();
            $table->text('education_end_date')->nullable();
            $table->text('education_description')->nullable();
            //contact
            $table->text('address')->nullable();
            $table->text('phone')->nullable();
            $table->text('email')->nullable();
            //skills
            $table->text('skills')->nullable();
            //language
            $table->text('language')->nullable();
            $table->text('leveleOf_language')->nullable();
            //course
            $table->text('course_title')->nullable();
            $table->text('course_year')->nullable();
            $table->text('course_description')->nullable();
            //experience
            $table->text('experiencetitle')->nullable();
            $table->text('experience_year')->nullable();
            $table->text('experience_description')->nullable();



            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cv5s');
    }
};