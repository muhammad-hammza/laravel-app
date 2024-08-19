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
        Schema::create('free_lancers', function (Blueprint $table) {
            $table->id();

            $table->string("image")->nullable();
            $table->string("user_id");
            $table->string("name");
            $table->string("email");
            $table->string("phone");
            $table->string("country");
            $table->string("state");
            $table->string("city");
            $table->string("experience");
            $table->longText("description");
            $table->string("functional_area");
            $table->string("skills");
            $table->string("per_hour_price");
            $table->string("currency");

            $table->decimal('review', 3, 2)->nullable(); // Adjusted to allow ratings up to 5.00


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('free_lancers');
    }
};
