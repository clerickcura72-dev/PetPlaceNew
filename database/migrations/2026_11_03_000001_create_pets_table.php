<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pet_owner_id')->constrained('pet_owners')->cascadeOnDelete();
            $table->string('name');
            $table->string('type');               // dog, cat, bird, rabbit, fish, other
            $table->string('breed')->nullable();
            $table->string('sex')->nullable();    // male, female
            $table->date('birth_date')->nullable();
            $table->text('notes')->nullable();    // allergies, special care, etc.
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};
