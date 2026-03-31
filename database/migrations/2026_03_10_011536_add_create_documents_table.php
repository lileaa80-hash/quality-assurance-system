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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique();
            $table->string('title');
            
            // Kolom Type (Pastikan 'standard' ada di sini)
            $table->enum('type', [
                'sop', 'manual_mutu', 'standard', 'formulir', 'pedoman', 
                'kebijakan', 'laporan', 'sertifikat', 'borang'
            ]);

            // Kolom Status
            $table->enum('status', [
                'draft', 'review', 'approved', 'published', 
                'archived', 'obsolete'
            ])->default('draft');
            
            // Hierarki & Versi
            $table->foreignId('parent_id')->nullable()->constrained('documents');
            $table->integer('current_version')->default(1);
            $table->date('effective_date')->nullable();
            $table->date('review_date')->nullable();
            $table->date('expiry_date')->nullable();
            
            // User Relations
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            
            // File & QR
            $table->boolean('is_controlled')->default(true);
            $table->json('distribution_units')->nullable();
            $table->string('file_path')->nullable();
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('mime_type')->nullable();
            $table->string('qr_code')->nullable();
            
            // Others
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            // Indexing untuk performa
            $table->index(['type', 'status', 'effective_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};