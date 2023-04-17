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
        Schema::create("scrap_earthquakes", function (Blueprint $table) {
            $table->id();
            $table->text("time");
            $table->text("latitude"); // lintang
            $table->text("longitude"); // bujur
            $table->text("depth"); // kedalaman
            $table->text("magnitudes"); // magnitude
            $table->text("region"); // wilayah
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("scrap_earthquakes");
    }
};
