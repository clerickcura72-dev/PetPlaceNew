<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Allow the "admin" role on the users table.
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('vet', 'owner', 'admin')
            NOT NULL DEFAULT 'owner'
        ");

        // 2. Vets must be approved by an admin before they can log in.
        //    Existing vets default to "approved" so nobody gets locked out.
        if (! Schema::hasColumn('vets', 'approval_status')) {
            Schema::table('vets', function (Blueprint $table) {
                $table->string('approval_status')->default('approved');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('vets', 'approval_status')) {
            Schema::table('vets', function (Blueprint $table) {
                $table->dropColumn('approval_status');
            });
        }

        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM('vet', 'owner')
            NOT NULL DEFAULT 'owner'
        ");
    }
};
