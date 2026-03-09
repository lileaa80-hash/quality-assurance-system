# SISTEM PENJAMINAN MUTU (Quality Assurance System)
## Fullstack dengan Laravel + Filament + MinIO

---

## DAFTAR ISI
1. [Konsep Bisnis](#1-konsep-bisnis)
2. [Struktur Database](#2-struktur-database)
3. [Laravel Migration Tables (Lengkap)](#3-laravel-migration-tables-lengkap)
4. [Integrasi MinIO](#4-integrasi-minio)
5. [Relasi Antar Tabel](#5-relasi-antar-tabel)
6. [Fitur Filament](#6-fitur-filament)

---

## 1. KONSEP BISNIS

### 1.1. Gambaran Umum
Sistem Penjaminan Mutu untuk institusi pendidikan/perguruan tinggi yang mengelola seluruh dokumen dan proses akreditasi, audit internal, evaluasi, dan standar mutu.

### 1.2. 5 Aktor Utama

| Aktor | Panel | Tugas Utama |
|-------|-------|-------------|
| **Super Admin (BADAN PENJAMINAN MUTU)** | Admin Panel | • Kelola seluruh sistem<br>• Kelola pengguna & role<br>• Lihat semua laporan<br>• Konfigurasi standar mutu |
| **Auditor Internal** | Auditor Panel | • Melakukan audit<br>• Mengisi checklist audit<br>• Upload temuan audit<br>• Membuat laporan audit |
| **Unit/Prodi** | Unit Panel | • Mengupload dokumen<br>• Mengisi borang akreditasi<br>• Menindaklanjuti temuan |
| **Pimpinan (Dekan/Rektor)** | Leader Panel | • Monitoring progress<br>• Menyetujui laporan<br>• Dashboard eksekutif |
| **Asesor Eksternal** | Asesor Panel | • Review dokumen<br>• Penilaian akreditasi |

### 1.3. Alur Bisnis Utama

#### 1.3.1. Siklus Audit Mutu Internal (AMI)

```
BPM (Admin) → Buat jadwal audit → Assign Auditor ke Unit
    ↓
Auditor → Upload instrumen audit → Lakukan audit
    ↓
Auditor → Temukan ketidaksesuaian → Upload bukti temuan (ke MinIO)
    ↓
Unit → Menerima temuan → Buat rencana perbaikan
    ↓
Auditor → Verifikasi perbaikan → Tutup temuan
    ↓
BPM → Generate laporan AMI → Arsipkan
```

#### 1.3.2. Alur Akreditasi Prodi

```
Prodi/Unit → Upload dokumen borang (ke MinIO)
    ↓
BPM → Verifikasi kelengkapan dokumen
    ↓
Asesor Eksternal → Review dokumen → Beri penilaian
    ↓
BPM → Hitung nilai akreditasi → Terbitkan sertifikat
    ↓
[System] Simpan di MinIO → Notifikasi ke Prodi
```

#### 1.3.3. Alur Pengendalian Dokumen Mutu

```
BPM → Buat standar mutu baru (SOP, Manual Mutu)
    ↓
Upload dokumen ke MinIO → Generate versi & QR code
    ↓
Distribusi ke unit terkait
    ↓
Unit → Konfirmasi penerimaan
    ↓
[System] Tracking dokumen yang sudah didistribusikan
```

### 1.4. Fitur Utama

| Modul | Deskripsi |
|-------|-----------|
| **Standar Mutu** | Kelola standar nasional/institusi (SN Dikti, ISO, dll) |
| **Audit Mutu Internal** | Jadwal, instrumen, temuan, tindak lanjut |
| **Akreditasi** | Borang, dokumen, penilaian, sertifikat |
| **Dokumen Mutu** | Repository SOP, Manual Mutu, Formulir (dengan MinIO) |
| **Evaluasi** | Kuesioner kepuasan, tracer study, evaluasi pembelajaran |
| **Pelaporan** | Dashboard, grafik, export PDF/Excel |

---

## 2. STRUKTUR DATABASE

### 2.1. Daftar Tabel (25 Tabel)

| No | Tabel | Fungsi |
|----|-------|--------|
| 1 | `users` | Data pengguna sistem |
| 2 | `roles_permissions` | Spatie Permission |
| 3 | `units` | Unit kerja / Program Studi |
| 4 | `standards` | Standar mutu (SN Dikti, ISO, dll) |
| 5 | `standard_indicators` | Indikator per standar |
| 6 | `documents` | Master dokumen mutu |
| 7 | `document_versions` | Versi dokumen (history) |
| 8 | `document_distributions` | Distribusi dokumen ke unit |
| 9 | `audit_schedules` | Jadwal audit |
| 10 | `audit_teams` | Tim auditor |
| 11 | `audit_checklists` | Instrumen/checklist audit |
| 12 | `audit_findings` | Temuan audit |
| 13 | `corrective_actions` | Rencana tindak lanjut |
| 14 | `accreditation_periods` | Periode akreditasi |
| 15 | `accreditation_borangs` | Borang akreditasi |
| 16 | `accreditation_scores` | Nilai akreditasi |
| 17 | `evaluation_questionnaires` | Kuesioner evaluasi |
| 18 | `evaluation_responses` | Jawaban kuesioner |
| 19 | `file_attachments` | File attachments (MinIO) |
| 20 | `notifications` | Notifikasi sistem |
| 21 | `activities` | Log aktivitas |
| 22 | `workflows` | Alur kerja persetujuan |
| 23 | `workflow_steps` | Step dalam workflow |
| 24 | `approvals` | Approval records |
| 25 | `reports` | Laporan tersimpan |

---

## 3. LARAVEL MIGRATION TABLES (LENGKAP)

### 3.1. Setup Awal Migration

```bash
# Buat project baru
composer create-project laravel/laravel quality-assurance-system
cd quality-assurance-system

# Install packages
composer require filament/filament:"^3.2"
composer require spatie/laravel-permission
composer require laravel/sanctum
composer require league/flysystem-aws-s3-v3 "^3.0" # Untuk MinIO
composer require barryvdh/laravel-dompdf
composer require maatwebsite/excel
```

---

### 3.2. Tabel Users

**File:** `database/migrations/2014_10_12_000000_create_users_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('nip')->nullable()->unique();
            $table->string('position')->nullable();
            $table->string('signature')->nullable(); // Tanda tangan digital
            $table->boolean('is_active')->default(true);
            $table->rememberToken();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
```

---

### 3.3. Tabel Units (Unit Kerja / Prodi)

**File:** `database/migrations/2024_01_01_000001_create_units_table.php`

```php
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
```

**Kolom Penting:**
- `code` - Kode unik unit (TI, MI, SI)
- `type` - Tipe unit (prodi, fakultas, lembaga)
- `parent_id` - Relasi hierarki (fakultas memiliki banyak prodi)
- `level` - Level dalam organisasi
- `accreditation_status` - Status akreditasi terakhir

---

### 3.4. Tabel User Unit (Relasi User ke Unit)

**File:** `database/migrations/2024_01_01_000002_create_user_units_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('user_units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained()->onDelete('cascade');
            $table->enum('role_in_unit', ['leader', 'member', 'quality_controller', 'auditee'])->default('member');
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['user_id', 'unit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_units');
    }
};
```

---

### 3.5. Tabel Standards (Standar Mutu)

**File:** `database/migrations/2024_01_01_000003_create_standards_table.php`

```php
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
```

**Contoh Data:**
```php
// Standar SN Dikti
['code' => 'SNDIKTI-1', 'name' => 'Standar Nasional Pendidikan - Visi, Misi, Tujuan']
['code' => 'SNDIKTI-2', 'name' => 'Standar Nasional Pendidikan - Tata Pamong']

// Standar ISO
['code' => 'ISO-9001-7.5', 'name' => 'Dokumentasi Sistem Manajemen Mutu']
```

---

### 3.6. Tabel Standard Indicators (Indikator Standar)

**File:** `database/migrations/2024_01_01_000004_create_standard_indicators_table.php`

```php
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
```

---

### 3.7. Tabel Documents (Master Dokumen Mutu)

**File:** `database/migrations/2024_01_01_000005_create_documents_table.php`

```php
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
```

---

### 3.8. Tabel Document Versions (Riwayat Versi Dokumen)

**File:** `database/migrations/2024_01_01_000006_create_document_versions_table.php`

```php
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
```

---

### 3.9. Tabel Document Distributions (Distribusi Dokumen)

**File:** `database/migrations/2024_01_01_000007_create_document_distributions_table.php`

```php
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
```

---

### 3.10. Tabel Audit Schedules (Jadwal Audit)

**File:** `database/migrations/2024_01_01_000008_create_audit_schedules_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_schedules', function (Blueprint $table) {
            $table->id();
            $table->string('audit_number')->unique(); // AUD/2024/001
            $table->string('title');
            $table->enum('type', ['internal', 'external', 'surveillance'])->default('internal');
            $table->enum('scope', ['institutional', 'faculty', 'program', 'specific'])->default('program');
            $table->year('period_year');
            $table->string('period_semester')->nullable(); // ganjil, genap
            
            // Waktu pelaksanaan
            $table->date('start_date');
            $table->date('end_date');
            $table->date('opening_date')->nullable(); // Tanggal pembukaan
            $table->date('closing_date')->nullable(); // Tanggal penutupan
            
            // Standar yang digunakan
            $table->json('standards_used'); // Array standard_id
            
            // Status
            $table->enum('status', [
                'planned', 'preparation', 'opened', 'ongoing', 
                'closing', 'completed', 'cancelled'
            ])->default('planned');
            
            // Dokumen pendukung (MinIO)
            $table->string('terms_of_reference')->nullable(); // TOR file
            $table->string('schedule_document')->nullable(); // Jadwal detail
            
            $table->text('notes')->nullable();
            $table->json('metadata')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index('type');
            $table->index('status');
            $table->index(['period_year', 'period_semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_schedules');
    }
};
```

---

### 3.11. Tabel Audit Teams (Tim Auditor)

**File:** `database/migrations/2024_01_01_000009_create_audit_teams_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_teams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('user_id')->constrained(); // Auditor
            $table->enum('role', ['lead_auditor', 'auditor', 'observer', 'trainee'])->default('auditor');
            $table->json('assigned_units')->nullable(); // Unit yang diaudit oleh auditor ini
            $table->json('assigned_standards')->nullable(); // Standar yang diaudit
            $table->boolean('is_certified')->default(false); // Auditor bersertifikat
            $table->string('certificate_number')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->unique(['audit_schedule_id', 'user_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_teams');
    }
};
```

---

### 3.12. Tabel Audit Checklists (Instrumen Audit)

**File:** `database/migrations/2024_01_01_000010_create_audit_checklists_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_checklists', function (Blueprint $table) {
            $table->id();
            $table->foreignId('audit_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained(); // Unit yang diaudit
            $table->foreignId('standard_id')->constrained(); // Standar yang diperiksa
            $table->foreignId('standard_indicator_id')->constrained(); // Indikator yang diperiksa
            
            // Hasil audit
            $table->enum('result', ['compliant', 'partially_compliant', 'non_compliant', 'not_applicable'])->nullable();
            $table->integer('score')->nullable(); // Skor jika menggunakan skala
            $table->text('objective_evidence')->nullable(); // Bukti objektif
            $table->text('notes')->nullable();
            
            // Auditor yang memeriksa
            $table->foreignId('auditor_id')->constrained('users');
            $table->datetime('checked_at')->nullable();
            
            // Upload bukti (MinIO)
            $table->json('evidence_files')->nullable(); // Array file paths
            
            $table->timestamps();
            
            $table->index(['audit_schedule_id', 'unit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_checklists');
    }
};
```

---

### 3.13. Tabel Audit Findings (Temuan Audit)

**File:** `database/migrations/2024_01_01_000011_create_audit_findings_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('audit_findings', function (Blueprint $table) {
            $table->id();
            $table->string('finding_number')->unique(); // TEM/2024/001
            $table->foreignId('audit_schedule_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained();
            $table->foreignId('audit_checklist_id')->nullable()->constrained();
            
            // Klasifikasi temuan
            $table->enum('category', ['major', 'minor', 'observation', 'strength'])->default('minor');
            $table->enum('type', ['systematic', 'sporadic', 'unique'])->default('sporadic');
            
            // Deskripsi temuan
            $table->text('finding_description');
            $table->text('criteria_reference'); // Referensi standar yang dilanggar
            $table->text('objective_evidence'); // Bukti temuan
            
            // Status
            $table->enum('status', [
                'open', 'in_progress', 'closed', 'verified'
            ])->default('open');
            
            // Severity
            $table->integer('risk_level')->default(1); // 1-5, 5 paling serius
            
            // Dokumen pendukung (MinIO)
            $table->json('supporting_files')->nullable();
            $table->string('photo_evidence')->nullable();
            
            // Auditor
            $table->foreignId('auditor_id')->constrained('users');
            $table->datetime('finding_date');
            
            $table->timestamps();
            
            $table->index('status');
            $table->index(['audit_schedule_id', 'unit_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('audit_findings');
    }
};
```

---

### 3.14. Tabel Corrective Actions (Rencana Tindak Lanjut)

**File:** `database/migrations/2024_01_01_000012_create_corrective_actions_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('corrective_actions', function (Blueprint $table) {
            $table->id();
            $table->string('ca_number')->unique(); // CAPA/2024/001
            $table->foreignId('audit_finding_id')->constrained()->onDelete('cascade');
            $table->foreignId('unit_id')->constrained();
            
            // Root cause analysis
            $table->text('root_cause');
            $table->enum('cause_category', [
                'human', 'method', 'machine', 'material', 'environment', 'other'
            ])->default('human');
            
            // Rencana perbaikan
            $table->text('corrective_action_plan');
            $table->text('preventive_action_plan')->nullable();
            $table->date('target_completion_date');
            
            // Pelaksana
            $table->foreignId('responsible_person')->constrained('users');
            
            // Implementasi
            $table->text('implementation_evidence')->nullable();
            $table->json('evidence_files')->nullable(); // Bukti perbaikan (MinIO)
            $table->date('implementation_date')->nullable();
            
            // Verifikasi
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('verification_notes')->nullable();
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->datetime('verified_at')->nullable();
            
            // Effectiveness
            $table->boolean('is_effective')->nullable();
            $table->enum('final_status', ['open', 'closed', 'reopened'])->default('open');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('corrective_actions');
    }
};
```

---

### 3.15. Tabel Accreditation Periods (Periode Akreditasi)

**File:** `database/migrations/2024_01_01_000013_create_accreditation_periods_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accreditation_periods', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained();
            $table->string('period_name'); // Akreditasi 2024, Reakreditasi, dll
            $table->enum('type', ['initial', 'reaccreditation', 'maintenance'])->default('initial');
            $table->enum('status', [
                'planned', 'preparation', 'submitted', 'assesment', 
                'waiting_result', 'completed', 'postponed'
            ])->default('planned');
            
            // Tanggal penting
            $table->date('start_date');
            $table->date('submission_deadline')->nullable();
            $table->date('assesment_date')->nullable();
            $table->date('result_date')->nullable();
            $table->date('expiry_date')->nullable();
            
            // Hasil
            $table->string('result_grade')->nullable(); // A, B, C, Unggul, Baik Sekali
            $table->integer('result_score')->nullable(); // Nilai numerik
            $table->string('certificate_number')->nullable();
            $table->string('certificate_file')->nullable(); // File sertifikat (MinIO)
            
            // Asesor
            $table->json('assessors')->nullable(); // Data asesor eksternal
            
            $table->json('metadata')->nullable();
            $table->timestamps();
            
            $table->index(['unit_id', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accreditation_periods');
    }
};
```

---

### 3.16. Tabel Accreditation Borangs (Borang Akreditasi)

**File:** `database/migrations/2024_01_01_000014_create_accreditation_borangs_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('accreditation_borangs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('accreditation_period_id')->constrained()->onDelete('cascade');
            $table->foreignId('standard_id')->constrained();
            $table->foreignId('standard_indicator_id')->constrained();
            
            // Isian borang
            $table->text('response')->nullable();
            $table->text('analysis')->nullable();
            $table->string('target')->nullable();
            $table->string('achievement')->nullable();
            
            // Dokumen pendukung (MinIO)
            $table->json('supporting_documents')->nullable();
            
            // Penilaian
            $table->integer('self_assessment_score')->nullable(); // Penilaian mandiri
            $table->integer('assessor_score')->nullable(); // Penilaian asesor
            $table->text('assessor_notes')->nullable();
            
            // Status pengisian
            $table->enum('status', ['draft', 'submitted', 'verified', 'revised'])->default('draft');
            $table->foreignId('filled_by')->constrained('users');
            $table->foreignId('verified_by')->nullable()->constrained('users');
            $table->datetime('verified_at')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('accreditation_borangs');
    }
};
```

---

### 3.17. Tabel Evaluation Questionnaires (Kuesioner Evaluasi)

**File:** `database/migrations/2024_01_01_000015_create_evaluation_questionnaires_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('evaluation_questionnaires', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('type', [
                'student_satisfaction', 
                'lecturer_performance',
                'alumni_tracer',
                'stakeholder_satisfaction',
                'self_evaluation'
            ]);
            
            // Periode
            $table->year('year');
            $table->string('semester')->nullable();
            $table->date('start_date');
            $table->date('end_date');
            
            // Target responden
            $table->enum('target_audience', [
                'students', 'lecturers', 'staff', 'alumni', 'stakeholders', 'all'
            ]);
            $table->json('target_units')->nullable(); // Unit yang menjadi target
            
            // Status
            $table->enum('status', ['draft', 'active', 'closed', 'archived'])->default('draft');
            
            // Pengaturan
            $table->boolean('is_anonymous')->default(true);
            $table->boolean('allow_multiple_submissions')->default(false);
            
            // Laporan
            $table->json('summary_report')->nullable();
            $table->string('report_file')->nullable(); // File laporan (MinIO)
            
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();
            
            $table->index(['type', 'year', 'semester']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('evaluation_questionnaires');
    }
};
```

---

### 3.18. Tabel Evaluation Questions (Pertanyaan Kuesioner)

**File:** `database/migrations/2024_01_01_000016_create_evaluation_questions_table.php`

```php
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
            $table->foreignId('questionnaire_id')->constrained()->onDelete('cascade');
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
```

**Contoh JSON options:**
```json
// Likert 5
{
    "1": "Sangat Tidak Puas",
    "2": "Tidak Puas", 
    "3": "Cukup",
    "4": "Puas",
    "5": "Sangat Puas"
}

// Multiple Choice
{
    "A": "Sangat Baik",
    "B": "Baik",
    "C": "Cukup",
    "D": "Kurang"
}
```

---

### 3.19. Tabel Evaluation Responses (Jawaban Kuesioner)

**File:** `database/migrations/2024_01_01_000017_create_evaluation_responses_table.php`

```php
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
            $table->foreignId('questionnaire_id')->constrained()->onDelete('cascade');
            $table->foreignId('question_id')->constrained('evaluation_questions')->onDelete('cascade');
            $table->foreignId('respondent_id')->nullable()->constrained('users'); // Jika login
            
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
```

---

### 3.20. Tabel File Attachments (MinIO)

**File:** `database/migrations/2024_01_01_000018_create_file_attachments_table.php`

```php
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
```

---

### 3.21. Tabel Workflows (Alur Persetujuan)

**File:** `database/migrations/2024_01_01_000019_create_workflows_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflows', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('code')->unique();
            $table->enum('type', [
                'document_approval',
                'audit_report_approval',
                'corrective_action_approval',
                'accreditation_approval'
            ]);
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflows');
    }
};
```

---

### 3.22. Tabel Workflow Steps (Step dalam Workflow)

**File:** `database/migrations/2024_01_01_000020_create_workflow_steps_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('workflow_steps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workflow_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->integer('step_order');
            $table->enum('approver_type', ['role', 'user', 'unit_head', 'position'])->default('role');
            $table->string('approver_value'); // role_id, user_id, atau position
            $table->boolean('requires_approval')->default(true);
            $table->integer('time_limit_days')->nullable(); // Batas waktu approval
            $table->json('conditions')->nullable(); // Kondisi untuk step ini
            $table->timestamps();
            
            $table->unique(['workflow_id', 'step_order']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('workflow_steps');
    }
};
```

---

### 3.23. Tabel Approvals (Catatan Persetujuan)

**File:** `database/migrations/2024_01_01_000021_create_approvals_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('approvals', function (Blueprint $table) {
            $table->id();
            $table->morphs('approvable'); // Document, AuditReport, etc
            $table->foreignId('workflow_step_id')->constrained();
            $table->foreignId('approver_id')->constrained('users');
            $table->enum('status', ['pending', 'approved', 'rejected', 'revised'])->default('pending');
            $table->text('notes')->nullable();
            $table->timestamp('action_at')->nullable();
            $table->timestamps();
            
            $table->index(['approvable_id', 'approvable_type', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('approvals');
    }
};
```

---

### 3.24. Tabel Notifications (Notifikasi)

**File:** `database/migrations/2024_01_01_000022_create_notifications_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('type');
            $table->morphs('notifiable');
            $table->text('data');
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
```

---

### 3.25. Tabel Activities (Log Aktivitas)

**File:** `database/migrations/2024_01_01_000023_create_activities_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {
            $table->id();
            $table->string('log_name')->nullable();
            $table->text('description');
            $table->nullableMorphs('subject');
            $table->nullableMorphs('causer');
            $table->json('properties')->nullable();
            $table->string('event')->nullable(); // created, updated, deleted, approved
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();
            
            $table->index('log_name');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
```

---

### 3.26. Tabel Reports (Laporan Tersimpan)

**File:** `database/migrations/2024_01_01_000024_create_reports_table.php`

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->enum('type', [
                'audit_summary',
                'accreditation_result',
                'evaluation_summary',
                'document_status',
                'finding_trend',
                'custom'
            ]);
            $table->json('parameters')->nullable(); // Parameter laporan
            $table->json('data_summary')->nullable(); // Ringkasan data
            $table->string('file_path')->nullable(); // File generated (PDF/Excel) di MinIO
            $table->enum('format', ['pdf', 'excel', 'html'])->default('pdf');
            
            // Periode laporan
            $table->year('year')->nullable();
            $table->string('quarter')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            
            // Pembuat
            $table->foreignId('created_by')->constrained('users');
            $table->timestamp('generated_at');
            
            $table->timestamps();
            
            $table->index(['type', 'year']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
```

---

## 4. INTEGRASI MINIO

### 4.1. Konfigurasi MinIO di Laravel

**File:** `.env`
```env
# MinIO Configuration
FILESYSTEM_DISK=minio
MINIO_ACCESS_KEY=minioadmin
MINIO_SECRET_KEY=minioadmin
MINIO_ENDPOINT=http://localhost:9000
MINIO_BUCKET=quality-assurance
MINIO_REGION=us-east-1
MINIO_USE_PATH_STYLE_ENDPOINT=true
```

**File:** `config/filesystems.php`
```php
'disks' => [
    // ... other disks
    
    'minio' => [
        'driver' => 's3',
        'key' => env('MINIO_ACCESS_KEY'),
        'secret' => env('MINIO_SECRET_KEY'),
        'region' => env('MINIO_REGION', 'us-east-1'),
        'bucket' => env('MINIO_BUCKET'),
        'endpoint' => env('MINIO_ENDPOINT'),
        'use_path_style_endpoint' => env('MINIO_USE_PATH_STYLE_ENDPOINT', true),
        'throw' => false,
    ],
],
```

### 4.2. Struktur Bucket MinIO

```
quality-assurance/
├── documents/
│   ├── sop/
│   │   ├── 2024/
│   │   │   ├── SOP-001-v1.pdf
│   │   │   └── SOP-001-v2.pdf
│   ├── manual-mutu/
│   ├── formulir/
│   └── pedoman/
├── audit/
│   ├── instrumen/
│   ├── temuan/
│   │   ├── AUD-2024-001/
│   │   │   ├── bukti1.jpg
│   │   │   └── bukti2.pdf
│   └── laporan/
├── akreditasi/
│   ├── borang/
│   ├── dokumen-pendukung/
│   └── sertifikat/
├── evaluasi/
│   ├── hasil-kuesioner/
│   └── laporan/
├── reports/
│   ├── pdf/
│   └── excel/
└── qr-codes/
    ├── documents/
    └── certificates/
```

### 4.3. Helper Upload ke MinIO

**File:** `app/Services/MinIOService.php`
```php
<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class MinIOService
{
    /**
     * Upload file to MinIO
     */
    public function upload(UploadedFile $file, string $path, string $filename = null): string
    {
        $filename = $filename ?? $file->hashName();
        $fullPath = $path . '/' . $filename;
        
        Storage::disk('minio')->putFileAs($path, $file, $filename);
        
        return $fullPath;
    }
    
    /**
     * Get temporary URL for file (for secure access)
     */
    public function getTemporaryUrl(string $path, int $expiresInMinutes = 5): string
    {
        return Storage::disk('minio')->temporaryUrl($path, now()->addMinutes($expiresInMinutes));
    }
    
    /**
     * Delete file from MinIO
     */
    public function delete(string $path): bool
    {
        return Storage::disk('minio')->delete($path);
    }
    
    /**
     * Check if file exists
     */
    public function exists(string $path): bool
    {
        return Storage::disk('minio')->exists($path);
    }
    
    /**
     * Get file metadata
     */
    public function getMetadata(string $path): array
    {
        return [
            'size' => Storage::disk('minio')->size($path),
            'last_modified' => Storage::disk('minio')->lastModified($path),
            'mime_type' => Storage::disk('minio')->mimeType($path),
        ];
    }
}
```

---

## 5. RELASI ANTAR TABEL

### 5.1. Diagram Relasi (Ringkasan)

```
users
  ├── hasMany units (through user_units)
  ├── hasMany documents (created_by)
  ├── hasMany audit_schedules (created_by)
  ├── hasMany audit_findings (auditor_id)
  └── hasMany approvals (approver_id)

units
  ├── hasMany users (through user_units)
  ├── hasMany documents (distribution)
  ├── hasMany audit_schedules
  ├── hasMany audit_findings
  └── hasMany accreditation_periods

standards
  ├── hasMany standard_indicators
  └── belongsToMany audit_schedules

documents
  ├── hasMany document_versions
  ├── hasMany document_distributions
  └── morphMany file_attachments

audit_schedules
  ├── hasMany audit_teams
  ├── hasMany audit_checklists
  ├── hasMany audit_findings
  └── belongsToMany standards

audit_findings
  ├── hasOne corrective_actions
  └── morphMany file_attachments

accreditation_periods
  ├── hasMany accreditation_borangs
  └── morphMany file_attachments

evaluation_questionnaires
  ├── hasMany evaluation_questions
  └── hasMany evaluation_responses
```

---

## 6. FITUR FILAMENT

### 6.1. Admin Panel Resources

| Resource | Fungsi |
|----------|--------|
| `UserResource` | Kelola pengguna & role |
| `UnitResource` | Kelola unit/prodi |
| `StandardResource` | Kelola standar mutu |
| `DocumentResource` | Kelola dokumen mutu (dengan MinIO) |
| `AuditScheduleResource` | Kelola jadwal audit |
| `AuditFindingResource` | Kelola temuan audit |
| `CorrectiveActionResource` | Kelola tindak lanjut |
| `AccreditationResource` | Kelola akreditasi |
| `EvaluationResource` | Kelola kuesioner |
| `ReportResource` | Generate laporan |

### 6.2. Widget Dashboard

- **Statistik Dokumen** - Jumlah dokumen per status
- **Temuan Audit Terbuka** - List temuan yang belum ditindaklanjuti
- **Progress Akreditasi** - Status akreditasi per prodi
- **Grafik Evaluasi** - Hasil kuesioner dalam bentuk chart
- **Kalender Audit** - Jadwal audit mendatang

### 6.3. Fitur Khusus dengan MinIO

- **Preview Dokumen** - View PDF/Image langsung dari MinIO
- **Upload Progress** - Progress bar upload ke MinIO
- **Versioning** - Riwayat versi dokumen
- **QR Code Generation** - Generate QR untuk akses cepat dokumen
- **Bulk Download** - Download multiple files sebagai ZIP

---

## 7. KESIMPULAN

Sistem Penjaminan Mutu ini memiliki:

1. **25 Tabel Database** lengkap dengan relasi
2. **Integrasi MinIO** untuk penyimpanan file yang scalable
3. **5 Aktor** dengan hak akses berbeda
4. **4 Modul Utama**: Standar Mutu, Audit, Akreditasi, Evaluasi
5. **Workflow Approval** untuk persetujuan berjenjang
6. **Reporting** lengkap dengan export PDF/Excel
7. **Filament Admin** untuk kemudahan pengelolaan
