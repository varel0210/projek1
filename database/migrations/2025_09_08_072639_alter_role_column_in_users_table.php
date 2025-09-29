<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // ubah kolom role jadi string
            $table->string('role', 100)->default('user')->change();
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // fallback ke enum jika rollback
            $table->enum('role', ['admin','user'])->default('user')->change();
        });
    }
};

