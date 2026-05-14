# Docker Configuration for EasyPanel

Folder ini berisi file pendukung untuk deploy aplikasi ke EasyPanel menggunakan setup **PHP-FPM + Caddy Server**.

## Struktur File Utama
- **`Dockerfile.easypanel.frankenphp`**: File utama untuk build Docker image. Menggunakan Alpine Linux yang ringan dan Supervisor untuk manajemen proses.
- **`docker/Caddyfile.easypanel.phpfpm`**: Konfigurasi Caddy Web Server yang dioptimalkan untuk Laravel.

## Fitur Setup Ini
1. **Multi-Process Management**: Menggunakan Supervisor untuk menjalankan dan memantau:
   - PHP-FPM (Proses PHP)
   - Caddy Server (Web Server)
   - Laravel Queue Worker (Pemroses antrian)
2. **Auto-Recovery**: Jika ada layanan (PHP/Caddy/Worker) yang mati, Supervisor akan otomatis menjalankannya kembali.
3. **Optimized Logging**: Semua log (akses web, error PHP, dan queue worker) langsung diteruskan ke log standar EasyPanel sehingga mudah dipantau.
4. **Queue Worker**: Sudah menyertakan worker untuk antrian `high` dan `default`.

## Cara Update Konfigurasi Antrian (Queue)
Jika Anda ingin mengubah konfigurasi Queue Worker, Anda dapat mengubah baris `[program:laravel-worker]` di dalam file `Dockerfile.easypanel.frankenphp`.
