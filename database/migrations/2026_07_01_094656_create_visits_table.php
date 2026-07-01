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
        Schema::create('visits', function (Blueprint $table) {
            $table->id();

            $table->foreignId('link_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->ipAddress();

            $table->text('user_agent');

            $table->text('referer')->nullable();

            $table->string('country', 100)->nullable();

            $table->string('city', 100)->nullable();

            $table->timestamp('visited_at')->useCurrent();
            $table->timestamps();

            $table->index('link_id');
            $table->index('visited_at');
            $table->index('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('visits');
    }
};
