<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('perlakuan_risikos', function (Blueprint $table) {
            $table->text('komentar')->nullable()->after('dokumen_pdf');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perlakuan_risikos', function (Blueprint $table) {
            $table->dropColumn('komentar');
        });
    }
};
