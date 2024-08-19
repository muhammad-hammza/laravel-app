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
        Schema::create('job_data', function (Blueprint $table) {
            $table->id();
            $table->string('user_id')->nullable();

            $table->string('image')->nullable();
            $table->string('job_title');
            $table->string('funcrional_area');
            $table->string('industry');
            $table->string('skill');
            $table->string('country');
            $table->string("state");
            $table->string('city');
            $table->string('company_name');
            $table->longText("description");
            $table->string('job_type');
            $table->string('Phone')->nullable();
            $table->string('Email');
            $table->string('Salary')->nullable();
            $table->string('Certifications'); //brwanama
            $table->string('Period'); //
            $table->string('currency'); //
            $table->string('gender'); //

            $table->string('Expire_Date')->nullable();
            $table->string('Experience');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_data');
    }
};
