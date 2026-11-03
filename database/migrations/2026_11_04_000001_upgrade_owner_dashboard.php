<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Pet photo
        Schema::table('pets', function (Blueprint $table) {
            $table->string('photo_path')->nullable()->after('notes');
        });

        // Dose number on vaccination records
        Schema::table('vaccination_records', function (Blueprint $table) {
            $table->unsignedTinyInteger('dose_number')->nullable()->after('next_due_date');
        });

        // "Any available veterinarian" = an appointment with no vet assigned yet
        Schema::table('appointments', function (Blueprint $table) {
            $table->dropForeign(['vet_id']);
        });
        Schema::table('appointments', function (Blueprint $table) {
            $table->unsignedBigInteger('vet_id')->nullable()->change();
        });
        Schema::table('appointments', function (Blueprint $table) {
            $table->foreign('vet_id')->references('id')->on('vets')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pets', fn (Blueprint $table) => $table->dropColumn('photo_path'));
        Schema::table('vaccination_records', fn (Blueprint $table) => $table->dropColumn('dose_number'));
    }
};
