<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('code')->nullable()->after('phone');
        });

        DB::table('users')
            ->select('id', 'phone')
            ->orderBy('id')
            ->get()
            ->each(function ($user) {
                $phone = trim((string) $user->phone);

                if ($phone === '') {
                    return;
                }

                if (!preg_match('/^(\+\d+)\s+(.*)$/', $phone, $matches)) {
                    return;
                }

                DB::table('users')
                    ->where('id', $user->id)
                    ->update([
                        'code' => $matches[1],
                        'phone' => trim($matches[2]),
                    ]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('code');
        });
    }
};
