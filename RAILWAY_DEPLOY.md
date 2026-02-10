# Panduan Setup Railway (Pasca-Deploy)

Selamat! Aplikasi Anda sudah berstatus **Active**. Ini berarti Docker container berhasil berjalan dengan PHP 7.4.

## 1. Cara Membuka Web (Generate Domain)
Agar aplikasi bisa diakses publik, Anda perlu membuat domain:
1.  Klik kartu service **OMDBDash_Movie** di dashboard Railway.
2.  Pilih tab **Settings**.
3.  Scroll ke bagian **Networking**.
4.  Klik tombol **Generate Domain**.
5.  Akan muncul link (contoh: `xxxxx.up.railway.app`). Klik link tersebut untuk membuka web.

## 2. PENTING: Environment Variables
Aplikasi mungkin masih akan error (500) jika konfigurasi belum lengkap. Anda perlu memasukkan "rahasia" aplikasi di tab **Variables**.

Tambahkan variabel berikut:
-   `APP_NAME`: `MovieApp`
-   `APP_ENV`: `production`
-   `APP_KEY`: (Copy dari file `.env` di komputer Anda, contoh: `base64:....`)
-   `APP_DEBUG`: `true` (Nyalakan dulu untuk cek error, nanti matikan jadi `false`)
-   `APP_URL`: (Masukkan domain yang baru di-generate tadi, pakai `https://`)

## 3. Database (Wajib!)
Secara default, aplikasi akan mencoba pakai SQLite. Di Railway, file SQLite **akan hilang** setiap kali restart/deploy.
Sangat disarankan memakai **MySQL** di Railway:
1.  Klik tombol **+ New** di dashboard Railway -> **Database** -> **MySQL**.
2.  Setelah MySQL Active, klik kartunya -> **Variables**.
3.  Kembali ke kartu aplikasi Movie App -> **Variables**.
4.  Tambahkan koneksi database (Railway biasanya menyediakan variabel `MYSQL_URL` atau Anda copy manual):
    -   `DB_CONNECTION`: `mysql`
    -   `DB_HOST`: (Host dari MySQL service)
    -   `DB_PORT`: (Port, biasanya 3306)
    -   `DB_DATABASE`: (Nama database)
    -   `DB_USERNAME`: (Username)
    -   `DB_PASSWORD`: (Password)

## 4. Menjalankan Migrasi (Create Tables)
Setelah database terkoneksi, tabel-tabel belum ada otomatis.
1.  Buka service aplikasi Movie App.
2.  Pilih tab **Shell** (Terminal).
3.  Ketik perintah:
    ```bash
    php artisan migrate
    ```
4.  Tunggu sampai selesai ("Migration table created successfully").
5.  (Opsional) Seed data:
    ```bash
    php artisan db:seed --force
    ```

Selesai! Aplikasi siap digunakan sepenuhnya.
