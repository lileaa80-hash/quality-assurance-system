<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class TestMinioConnection extends Command
{
    // Nama perintah yang akan dipanggil di terminal
    protected $signature = 'minio:test';
    
    // Deskripsi perintah
    protected $description = 'Test MinIO connection and operations on Laravel 12';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('Sedang mengetes koneksi MinIO kamu...');

        try {
            $testContent = 'Halo Erlia! File ini berhasil terkirim dari Laravel 12 - ' . now();
            $testPath = 'test/test_' . time() . '.txt';
            
            // Menggunakan disk s3 yang sudah dikonfigurasi untuk MinIO
            $this->info('1. Mencoba menulis file...');
            Storage::disk('s3')->put($testPath, $testContent);
            $this->info('   ✓ Tes menulis file (Write): BERHASIL!');
            
            $this->info('2. Mencoba membaca file...');
            $content = Storage::disk('s3')->get($testPath);
            if ($content === $testContent) {
                $this->info('   ✓ Tes membaca file (Read): BERHASIL!');
            } else {
                $this->warn('   ⚠ Konten file tidak cocok!');
            }
            
            $url = Storage::disk('s3')->url($testPath);
            $this->info("   ✓ URL File kamu: {$url}");
            
            $this->info('3. Mencoba menghapus file tes...');
            Storage::disk('s3')->delete($testPath);
            $this->info('   ✓ Tes menghapus file (Delete): BERHASIL!');
            
            $this->info('✅ MANTAP! Semua tes koneksi MinIO lolos tanpa error!');
            
        // } catch (\Exception $e) {
        //     $this->error('❌ Waduh Error: ' . $e->getMessage());
            
        //     $this->line('');
        //     $this->comment('💡 Tips Pengecekan:');
        //     $this->comment('- Pastikan server MinIO kamu sudah menyala.');
        //     $this->comment('- Cek kembali AWS_ENDPOINT, AWS_KEY, dan AWS_SECRET di file .env kamu.');
        //     $this->comment('- Pastikan AWS_BUCKET yang kamu tuju sudah dibuat di dashboard MinIO.');
        //     $this->comment('- Jangan lupa jalankan: composer require league/flysystem-aws-s3-v3');
            
        //     return Command::FAILURE; // Mengembalikan status 1 jika error
        // }
        
        return Command::SUCCESS; // Mengembalikan status 0 jika sukses
    }
}