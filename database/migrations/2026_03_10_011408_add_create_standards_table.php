<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('standards', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // SNDIKTI-1, ISO-9001-7.5, dll
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('type', ['sndikti', 'iso', 'institutional', 'other'])->default('institutional');
            $table->string('version')->default('1.0');
            $table->foreignId('parent_id')->nullable()->constrained('standards');
            $table->integer('order')->default(0);
            $table->json('references')->nullable(); // Referensi dokumen terkait
            $table->boolean('is_active')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('type');
            $table->index('version');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('standards');
    }
};