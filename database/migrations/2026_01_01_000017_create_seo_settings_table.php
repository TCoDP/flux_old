<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page');                           // route key: home, pricing, about...
            $table->string('locale', 5)->default('ru');
            $table->string('title')->nullable();
            $table->string('description', 500)->nullable();
            $table->string('keywords')->nullable();
            $table->string('og_image')->nullable();
            $table->json('schema')->nullable();               // schema.org JSON-LD overrides
            $table->timestamps();

            $table->unique(['page', 'locale']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
    }
};
