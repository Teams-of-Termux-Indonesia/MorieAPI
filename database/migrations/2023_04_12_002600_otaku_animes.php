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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->text('japanese')->nullable();
            $table->text('score')->nullable();
            $table->text('producers')->nullable();
            $table->text('type')->nullable();
            $table->text('studio')->nullable();
            $table->text('genre')->nullable();
            
            $table->integer('total_episode')->default(0);
            $table->text("slug")->unique();
            $table->text("thumbnail");
            $table->text("synopsis");
            $table->string("status")->default("unknown");
            $table->text("release_date");
            $table->json("episodes")->default([]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
