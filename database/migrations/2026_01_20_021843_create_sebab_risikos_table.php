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
        Schema::create('sebab_risikos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sasaran_id')->constrained()->onDelete('cascade');
            $table->foreignId('kategori_id')->constrained()->cascadeOnDelete();
            $table->text('nama_sebab');
            $table->text('pengendalian_internal');
            $table->string('referensi_pengendalian');
            $table->string('efektifitas_pengendalian');
            $table->integer('dampak')->nullable();
            $table->integer('probabilitas')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sebab_risikos');
    }
};
