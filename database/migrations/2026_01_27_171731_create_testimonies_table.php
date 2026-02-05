<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;
    use Illuminate\Support\Facades\Schema;

    return new class extends Migration {
        public function up(): void
        {
            Schema::create('testimonies', function (Blueprint $table) {
                $table->id();

                $table->string('name');
                $table->string('surname');
                $table->unsignedTinyInteger('note')->nullable();
                $table->text('message');
                $table->text('description')->nullable();

                // statut du témoignage (actif / inactif)
                $table->boolean('status')->default(false);

                // utilisateur ayant modifié le statut
                $table->foreignId('status_updated_by')
                    ->nullable()
                    ->constrained('users')
                    ->nullOnDelete();

                $table->string('avatar')->nullable();

                $table->timestamps();
            });
        }

        public function down(): void
        {
            Schema::dropIfExists('testimonies');
        }
    };
