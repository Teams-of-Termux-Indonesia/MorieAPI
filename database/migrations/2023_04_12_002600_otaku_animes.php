<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create("otaku_animes", function (Blueprint $table) {
            $table->id();
            $table->text("uid")->unique();
            $table->text("title")->nullable();
            $table->text("japanese")->nullable();
            $table->text("score")->nullable();
            $table->text("producer")->nullable();
            $table->text("type")->nullable();
            $table->text("studio")->nullable();
            $table->text("genres")->nullable();
            $table->text("synopsis")->nullable();
            $table->text("duration")->nullable();
            $table->integer("total_episode")->default(0);

            $table->text("thumbnail")->nullable();
            $table->string("status")->default("unknown");
            $table->text("release_date")->default(now());
            $table->json("metadata")->default("{}");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists("otaku_animes");
    }
};
