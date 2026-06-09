<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('connections', function (Blueprint $table) {
            $table->string('remote_email')->nullable()->index()->after('access_token'); // client email on the 3x-ui panel
            $table->string('sub_id')->nullable()->index()->after('remote_email');        // subscription id on the panel
            $table->string('subscription_url')->nullable()->after('sub_id');              // sub link served by the panel
            $table->text('config_link')->nullable()->after('subscription_url');           // primary vless:// import link
        });
    }

    public function down(): void
    {
        Schema::table('connections', function (Blueprint $table) {
            $table->dropColumn(['remote_email', 'sub_id', 'subscription_url', 'config_link']);
        });
    }
};
