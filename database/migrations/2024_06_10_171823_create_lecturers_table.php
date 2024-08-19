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
        Schema::create('lecturers', function (Blueprint $table) {
            $table->id();
            $table->longText("image")->nullable();
            $table->longText('name');
            $table->longText('user_id');
            $table->longText('email');
            $table->longText('phone');
            $table->longText("description");
            $table->longText('language');
            $table->longText('duration'); // bo maway chanek
            $table->longText('price');
            $table->longText('currency');
            $table->longText('study_mode');//online yan offline
            $table->longText('numberOf_years_teaching'); //chan sala wana aletawa
            $table->longText('grade_level');//aste pol 
            $table->longText('Subject');//babat
            $table->longText('Certifications'); //brwanama
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lecturers');
    }
};