<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();

            $table->foreignId('reservation_id')
                ->constrained('reservations')
                ->cascadeOnDelete();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('service_id')
                ->constrained('services')
                ->cascadeOnDelete();

            $table->unsignedTinyInteger('note');

            $table->text('commentaire')->nullable();

            $table->dateTime('date');

            $table->timestamps();

            $table->unique('reservation_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};