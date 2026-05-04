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
        Schema::create('pastes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('slug', 8)->unique();
            $table->string('title', 255)->nullable();
            $table->longText('content');
            $table->string('language')->default('plaintext');
            $table->string('expiry_type');
            $table->string('visibility');
            $table->string('password')->nullable();
            $table->boolean('is_burned')->default(false);
            $table->integer('views_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();

            // Indexes
            $table->index('slug');
            $table->index('visibility');
            $table->index('expires_at');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pastes');
    }
};
