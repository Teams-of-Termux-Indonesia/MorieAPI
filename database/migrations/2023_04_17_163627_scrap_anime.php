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
        Schema::create("scrap_animes", function (Blueprint $table) {
            $table->id();
            $table->string("title");
            $table->string("author");
            $table->string("slug")->unique();
            $table->text("caption");
            $table->text("time");
            $table->text("thumbnail")->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("scrap_animes");
    }
};
