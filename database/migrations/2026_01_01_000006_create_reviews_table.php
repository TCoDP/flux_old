<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('author_name');
            $table->string('author_role')->nullable();
            $table->string('avatar')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->text('body');
            $table->string('locale', 5)->default('ru');
            $table->boolean('is_featured')->default(false);
            $table->string('status')->default('pending');     // pending | approved | rejected
            $table->timestamps();

            $table->index(['status', 'locale', 'is_featured']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
