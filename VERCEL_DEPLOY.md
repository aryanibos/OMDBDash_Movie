# Panduan Deployment ke Vercel

Berikut adalah langkah-langkah untuk mendeploy aplikasi Laravel Movie App ini ke Vercel.

## ⚠️ PENTING: Database SQLite & Vercel
Vercel adalah platform **Serverless** dan **Stateless**. Artinya:
1.  **File sistem bersifat read-only** (kecuali folder `/tmp`).
2.  **SQLite Database Hilang**: Anda **TIDAK BISA** menggunakan database SQLite lokal (`database.sqlite`) di Vercel, karena database akan ter-reset setiap kali aplikasi "tidur" atau di-deploy ulang.
3.  **Solusi**: Anda HARUS menggunakan database eksternal seperti **MySQL** atau **PostgreSQL** (Contoh provider gratis: Aiven, Supabase, Neon, PlanetScale).

## 1. Persiapan File
Saya sudah membuatkan file yang dibutuhkan:
-   `vercel.json`: Konfigurasi Vercel.
-   `api/index.php`: Jembatan antara Vercel dan Laravel.
-   `.vercelignore`: Mengabaikan file yang tidak perlu diupload.

## 2. Push ke GitHub
Upload semua kode ke repository GitHub Anda.

## 3. Setup Project di Vercel
1.  Buka dashboard Vercel -> **Add New Project**.
2.  Import repository GitHub Anda.
3.  **Framework Preset**: Pilih **Other**.
4.  **Environment Variables**: Tambahkan variabel berikut:

| Key | Value | Keterangan |
| :--- | :--- | :--- |
| `APP_KEY` | (Copy dari .env lokal) | `base64:...` |
| `APP_DEBUG` | `false` | Atau `true` untuk debugging |
| `APP_URL` | Kosongkan atau URL Vercel | Otomatis dihandle vercel.json |
| `DB_CONNECTION` | `mysql` | Ganti `sqlite` ke `mysql` |
| `DB_HOST` | (Host Database Anda) | IP/Domain DB Server |
| `DB_PORT` | `3306` | Port DB |
| `DB_DATABASE` | (Nama Database) | Nama DB |
| `DB_USERNAME` | (Username DB) | Username DB |
| `DB_PASSWORD` | (Password DB) | Password DB |

## 4. Deploy
Klik **Deploy**.

## Tips Tambahan
-   Pastikan Anda menjalankan `php artisan key:generate` di lokal untuk mendapatkan `APP_KEY` jika belum ada.
-   Untuk asset (CSS/JS) agar loading dengan benar, pastikan `APP_URL` diset dengan benar atau gunakan helper `secure_asset()` di kode jika perlu (sudah dihandle `vercel-php` biasanya).
-   Folder `public` adalah Document Root. `vercel.json` sudah mengaturnya.

Selamat mencoba!
