<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('konten', function (Blueprint $table) {
    $table->text('gambar')->nullable()->after('kategori_id');
});

    }

    public function down(): void
    {
        Schema::table('kontens', function (Blueprint $table) {
            if (Schema::hasColumn('kontens', 'gambar')) {
                $table->dropColumn('gambar');
            }
        });
    }
};
