<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('appointments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_id')->constrained('pets')->cascadeOnDelete();
            $table->foreignId('vet_id')->constrained('vets')->cascadeOnDelete();
            $table->string('service');
            $table->date('appointment_date');
            $table->time('appointment_time');
            $table->text('reason')->nullable();
            $table->string('status')->default('pending');   // pending, approved, declined, completed
            $table->text('vet_note')->nullable();           // vet's reply to the owner
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('appointments');
    }
};
