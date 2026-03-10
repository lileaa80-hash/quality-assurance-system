<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->string('document_number')->unique(); // Nomor dokumen: SOP/01/2024
            $table->string('title');
            $table->enum('type', [
                'sop', 'manual_mutu', 'formulir', 'pedoman', 
                'kebijakan', 'laporan', 'sertifikat', 'borang'
            ]);
            $table->enum('status', [
                'draft', 'review', 'approved', 'published', 
                'archived', 'obsolete'
            ])->default('draft');
            
            // Hierarki dokumen
            $table->foreignId('parent_id')->nullable()->constrained('documents');
            
            // Versi terkini
            $table->integer('current_version')->default(1);
            $table->date('effective_date')->nullable();
            $table->date('review_date')->nullable(); // Tanggal review berikutnya
            $table->date('expiry_date')->nullable();
            
            // Penanggung jawab
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            
            // Distribusi
            $table->boolean('is_controlled')->default(true); // Dokumen terkendali
            $table->json('distribution_units')->nullable(); // Unit yang menerima
            
            // MinIO path untuk file
            $table->string('file_path')->nullable(); // Path di MinIO
            $table->string('file_name')->nullable();
            $table->string('file_size')->nullable();
            $table->string('mime_type')->nullable();
            
            // QR Code
            $table->string('qr_code')->nullable(); // Path QR code image
            
            $table->text('description')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('type');
            $table->index('status');
            $table->index('effective_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};