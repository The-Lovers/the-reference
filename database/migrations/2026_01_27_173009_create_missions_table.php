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
        Schema::create('missions', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->text('description')->nullable();
            $table->json('list')->nullable();

            $table->boolean('status')->default(false);
            $table->boolean('is_featured')->default(false);

            $table->string('image')->nullable();
            $table->string('icon')->nullable();

            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('status_updated_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('featured_updated_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('missions');
    }
};
