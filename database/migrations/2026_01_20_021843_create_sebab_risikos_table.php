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
            $table->text('sebab_risiko');
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
