# SiAkad - Sistem Akademik

Sebuah sistem informasi akademik sederhana yang dibangun menggunakan CodeIgniter 4.

## 🚀 Langkah Menjalankan Aplikasi

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1.  **Clone Repositori**
    Pastikan Anda sudah mengunduh semua file proyek ke dalam direktori lokal Anda.

2.  **Instalasi Dependensi**
    Buka terminal atau command prompt, arahkan ke direktori root proyek Anda, dan jalankan perintah berikut untuk menginstal semua dependensi yang diperlukan:
    ```bash
    composer install
    ```

3.  **Konfigurasi Database**
    - Salin file `env` menjadi `.env`.
    - Buka file `.env` dan sesuaikan pengaturan database berikut dengan konfigurasi lokal Anda:
      ```
      database.default.hostname = localhost
      database.default.database = nama_database_anda
      database.default.username = user_database_anda
      database.default.password = password_database_anda
      database.default.DBDriver = MySQLi
      ```

4.  **Migrasi dan Seeding Database**
    Jalankan perintah berikut untuk membuat semua tabel yang diperlukan dan mengisi data awal (termasuk akun pengguna untuk pengujian):
    ```bash
    php spark migrate
    php spark db:seed UserSeeder
    php spark db:seed StudentSeeder
    ```

5.  **Jalankan Aplikasi**
    Terakhir, jalankan server pengembangan bawaan CodeIgniter dengan perintah:
    ```bash
    php spark serve
    ```
    Aplikasi sekarang akan dapat diakses melalui `http://localhost:8080`.

## Credentials untuk Pengujian

Anda dapat menggunakan akun berikut untuk masuk ke dalam sistem dan melakukan pengujian:

### Akun Admin
-   **Username**: `admin`
-   **Password**: `admin`

### Akun Mahasiswa (Student)
-   **Username**: `farras`
-   **Password**: `farras`