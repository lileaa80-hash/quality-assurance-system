<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_questions', function (Blueprint $table) {
            $table->id();
            // Bagian yang aku ubah: Menambahkan nama tabel 'evaluation_questionnaires'
            $table->foreignId('questionnaire_id')
                  ->constrained('evaluation_questionnaires') 
                  ->onDelete('cascade');
                  
            $table->string('section'); // Bagian kuesioner
            $table->text('question_text');
            $table->enum('type', [
                'likert_5', 'likert_4', 'multiple_choice', 'essay', 'rating'
            ])->default('likert_5');
            
            // Opsi jawaban (untuk multiple choice)
            $table->json('options')->nullable();
            
            // Skala likert default
            $table->json('scale_labels')->nullable();
            
            // Bobot pertanyaan
            $table->integer('weight')->default(1);
            
            // Urutan
            $table->integer('order')->default(0);
            
            // Apakah wajib diisi
            $table->boolean('is_required')->default(true);
            
            $table->timestamps();
            
            $table->index(['questionnaire_id', 'section']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_questions');
    }
};