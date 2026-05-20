<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestMinioConnection extends Command
{
    protected $signature = 'minio:test';
    protected $description = 'Test MinIO connection and operations';

    public function handle()
    {
        $this->info('Sedang mengetes koneksi MinIO kamu menggunakan Driver Resmi...');

        try {
            // 1. Tes Tulis File memakai put() standar Laravel
            $testContent = 'Halo Erlia! File ini berhasil terkirim menggunakan driver resmi Laravel 12!';
            $testPath = 'test/test_resmi_' . time() . '.txt';
            
            Storage::disk('minio')->put($testPath, $testContent);
            $this->info('✓ Tes Menulis File: BERHASIL!');
            
            // 2. Tes Baca File memakai get() standar Laravel
            $content = Storage::disk('minio')->get($testPath);
            if ($content === $testContent) {
                $this->info('✓ Tes Membaca File: BERHASIL!');
            }
            
            // 3. Tes Hapus File memakai delete() standar Laravel
            Storage::disk('minio')->delete($testPath);
            $this->info('✓ Tes Menghapus File: BERHASIL!');
            
            $this->info('✅ MANTAP SAKTI! Semua tes koneksi MinIO lolos tanpa error!');
            
        } catch (\Exception $e) {
            $this->error('❌ Error Terdeteksi: ' . $e->getMessage());
            return 1;
        }
        
        return 0;
    }
}