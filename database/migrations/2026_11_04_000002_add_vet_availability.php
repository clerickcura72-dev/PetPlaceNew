<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vets', function (Blueprint $table) {
            $table->json('working_days')->nullable();   // ["mon","tue",...]
            $table->time('work_start')->nullable();
            $table->time('work_end')->nullable();
            $table->json('days_off')->nullable();       // ["2026-12-25", ...]
        });
    }

    public function down(): void
    {
        Schema::table('vets', function (Blueprint $table) {
            $table->dropColumn(['working_days', 'work_start', 'work_end', 'days_off']);
        });
    }
};
