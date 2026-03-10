<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('document_distributions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->enum('distribution_type', ['softcopy', 'hardcopy', 'both'])->default('softcopy');
            $table->integer('copy_number')->nullable(); // Nomor salinan untuk hardcopy
            $table->datetime('distributed_at');
            $table->foreignId('distributed_by')->constrained('users');
            $table->datetime('received_at')->nullable(); // Konfirmasi terima
            $table->string('received_by')->nullable();
            $table->enum('status', ['sent', 'received', 'returned'])->default('sent');
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['document_id', 'unit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('document_distributions');
    }
};