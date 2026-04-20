<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->string('cover')->nullable()->after('description');
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->string('cover')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('services', function (Blueprint $table) {
            $table->dropColumn('cover');
        });

        Schema::table('destinations', function (Blueprint $table) {
            $table->dropColumn('cover');
        });
    }
};
