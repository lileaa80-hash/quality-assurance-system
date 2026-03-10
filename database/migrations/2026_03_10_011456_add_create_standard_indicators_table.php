<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('standard_indicators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('standard_id')->constrained()->onDelete('cascade');
            $table->string('code');
            $table->text('indicator_text');
            $table->enum('measurement_type', ['quantitative', 'qualitative', 'binary'])->default('quantitative');
            $table->string('target_value')->nullable(); // Target capaian
            $table->string('unit')->nullable(); // Satuan: %, skor 1-4, dll
            $table->json('formula')->nullable(); // Rumus perhitungan
            $table->json('evidence_requirements')->nullable(); // Jenis bukti yang diperlukan
            $table->integer('weight')->default(1); // Bobot dalam penilaian
            $table->integer('order')->default(0);
            $table->boolean('is_mandatory')->default(true);
            $table->timestamps();
            
            $table->unique(['standard_id', 'code']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('standard_indicators');
    }
};