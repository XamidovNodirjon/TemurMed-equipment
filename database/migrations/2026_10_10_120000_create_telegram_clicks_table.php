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
        Schema::create('telegram_clicks', function (Blueprint $table) {
            $table->id();
            $table->string('source', 16)->default('button'); // button | qr
            $table->string('locale', 5)->nullable();
            $table->string('ip_hash', 64)->nullable();
            $table->string('user_agent', 512)->nullable();



            $table->date('clicked_date')->index();
            $table->char('clicked_month', 7)->index(); // YYYY-MM
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('telegram_clicks');
    }
};
