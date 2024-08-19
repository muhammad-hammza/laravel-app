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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->longText("image")->nullable();
            $table->longText("title");
            $table->longText("user_id");
            $table->longText("delevery");
            $table->longText("type");
            $table->longText("description");
            $table->longText("phone");
            $table->longText("email");
            $table->longText("country");
            $table->longText("state");
            $table->longText("city");
            $table->longText("price");
            $table->longText("currency");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};