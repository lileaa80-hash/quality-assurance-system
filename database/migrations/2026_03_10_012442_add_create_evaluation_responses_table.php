<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_responses', function (Blueprint $table) {
            $table->id();
            
            // BAGIAN YANG DIUBAH: Menyesuaikan nama tabel kuesioner
            $table->foreignId('questionnaire_id')
                  ->constrained('evaluation_questionnaires') 
                  ->onDelete('cascade');
                  
            $table->foreignId('question_id')
                  ->constrained('evaluation_questions')
                  ->onDelete('cascade');
                  
            $table->foreignId('respondent_id')
                  ->nullable()
                  ->constrained('users'); // Jika login
            
            // Identitas responden (untuk anonymous)
            $table->string('respondent_type')->nullable(); // student, lecturer, etc
            $table->string('respondent_unit')->nullable(); // Unit responden
            $table->string('respondent_email')->nullable();
            
            // Jawaban
            $table->text('answer')->nullable(); // Untuk essay
            $table->integer('answer_value')->nullable(); // Untuk skala likert/rating
            $table->json('answer_options')->nullable(); // Untuk multiple choice
            
            // Metadata
            $table->string('session_id')->nullable(); // Untuk tracking tanpa login
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            
            $table->timestamps();
            
            $table->index(['questionnaire_id', 'respondent_id']);
            $table->index('session_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_responses');
    }
};