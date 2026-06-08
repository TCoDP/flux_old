<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Connection profiles — a user's secure access profile bound to a server.
     */
    public function up(): void
    {
        Schema::create('connections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subscription_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('server_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('device_id')->nullable()->constrained()->nullOnDelete();
            $table->string('name');
            $table->uuid('uuid')->unique();
            $table->string('access_token', 64)->unique();     // opaque profile token (no protocol exposed)
            $table->string('status')->default('active');      // active | paused | revoked
            $table->timestamp('last_handshake_at')->nullable();
            $table->unsignedBigInteger('bytes_up')->default(0);
            $table->unsignedBigInteger('bytes_down')->default(0);
            $table->timestamps();

            $table->index(['user_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('connections');
    }
};
