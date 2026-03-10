<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // Kode unit, misal: TI, MI, SI
            $table->string('name');
            $table->string('type')->default('prodi'); // prodi, fakultas, lembaga, biro
            $table->foreignId('parent_id')->nullable()->constrained('units'); // Hierarki unit
            $table->string('level')->default('unit'); // university, faculty, department
            $table->string('accreditation_status')->nullable(); // A, B, C, Unggul
            $table->date('accreditation_expiry')->nullable();
            $table->string('head_name')->nullable(); // Nama pimpinan
            $table->string('head_nip')->nullable();
            $table->text('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->json('metadata')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('type');
            $table->index('level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};