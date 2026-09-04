<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('services', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->string('titre');
            $table->text('description');
            $table->decimal('prix', 10, 2);
            $table->string('ville');
            $table->string('image')->nullable();
            $table->boolean('disponibilite')->default(true);
            $table->enum('statut', [
                'brouillon',
                'publie',
                'suspendu'
            ])->default('brouillon');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('services');
    }
};