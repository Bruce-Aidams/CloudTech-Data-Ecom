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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            // We use unsignedBigInteger for bundle_id manually or constrained if table exists. 
            // Since bundles table is created before, we can use constrained usually, but to be safe:
            $table->foreignId('bundle_id')->constrained()->onDelete('cascade');
            $table->string('recipient_phone');
            $table->string('status')->default('pending'); // pending, processing, completed, failed
            $table->decimal('cost', 10, 2);
            $table->string('reference')->unique();
            $table->json('response_data')->nullable(); // From the external processing
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
