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
        Schema::create('countries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('continent_id')
                  ->constrained()
                  ->cascadeOnDelete();

            $table->string('label_fr');
            $table->string('label_en');

            $table->string('code', 5)->unique();
            $table->string('flag', 5)->unique();
            $table->string('phone_code', 10)->nullable();
            $table->string('devise_label')->nullable();
            $table->string('devise_code', 5)->nullable();
            $table->boolean('is_un_member')->default(false);
            $table->boolean('is_observer')->default(false);
            $table->boolean('is_territory')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('countries');
    }
};
