<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('file_attachments', function (Blueprint $table) {
            $table->id();
            $table->morphs('attachable'); // Polymorphic relation ke berbagai model
            $table->string('filename');
            $table->string('original_filename');
            $table->string('file_path'); // Path di MinIO
            $table->string('disk')->default('minio'); // Storage disk
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->json('metadata')->nullable(); // Dimensions, duration, etc
            
            // Versi file
            $table->integer('version')->default(1);
            $table->boolean('is_current')->default(true);
            
            // Uploader
            $table->foreignId('uploaded_by')->constrained('users');
            
            $table->timestamps();
            
            $table->index(['attachable_id', 'attachable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('file_attachments');
    }
};