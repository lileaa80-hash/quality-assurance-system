<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->integer('version_number');
            $table->text('change_description')->nullable(); // Deskripsi perubahan
            $table->string('file_path'); // Path di MinIO (versi spesifik)
            $table->string('file_name');
            $table->string('file_size');
            $table->string('mime_type');
            
            // Status versi
            $table->enum('status', ['current', 'previous', 'archived'])->default('previous');
            
            // Approver
            $table->foreignId('created_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            
            $table->timestamps();
            
            $table->unique(['document_id', 'version_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_versions');
    }
};