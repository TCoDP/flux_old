<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('referrals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('referrer_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('referred_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('status')->default('pending');     // pending | confirmed | rewarded
            $table->decimal('reward_amount', 10, 2)->default(0);
            $table->timestamp('confirmed_at')->nullable();
            $table->timestamps();

            $table->index('referrer_id');
            $table->unique('referred_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('referrals');
    }
};
