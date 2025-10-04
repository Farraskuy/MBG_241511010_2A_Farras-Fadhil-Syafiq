# Sistem Pemantauan Bahan Baku MBG 

Sebuah sistem informasi sederhana untuk pemantauan bahan baku yang dibangun menggunakan CodeIgniter 4.
dalam rangka evaluasi tengah semester ganjil 3

## 🚀 Langkah Menjalankan Aplikasi

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut:

1.  **Clone Repositori**
    Pastikan Anda sudah mengunduh/melakukan clone semua file proyek ke dalam direktori lokal Anda.

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
    lakukan import database ke database yang telah dibuat menggunakan sql yang tersedia pada direktori proyek ini atau import struktur database mandiri menggunakan struktur data yang tersedia di bawah ini:
    
    ## Struktur Data Digunakan
    PERLU DIPERHATIKAN PADA RELASI CONSTRAINT YANG DI SEDIAKAN MENGALAMI ANOMALI DIMANA FORENKEY MENGARAH KE PRIMARY KEY DALAM BEBERAPA TABEL:
    HOW TO FIX?
    ```bash
    ALTER TABLE `permintaan` DROP FOREIGN KEY `permintaan_ibfk_1`;

    ALTER TABLE `permintaan` ADD  CONSTRAINT `permintaan_ibfk_1` FOREIGN KEY (`pemohon_id`) REFERENCES `user`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
    
    ALTER TABLE `permintaan_detail` DROP FOREIGN KEY `permintaan_detail_ibfk_1`; 
    
    ALTER TABLE `permintaan_detail` ADD CONSTRAINT `permintaan_detail_ibfk_1` FOREIGN KEY (`permintaan_id`) REFERENCES `permintaan`(`id`) ON DELETE RESTRICT ON UPDATE RESTRICT;
    ```
    
    ### Model Data Logis (Logical Data Model):
    [Lihat Model Data Logis](https://dbdiagram.io/d/Proyek-3-Pemantauan-Bahan-Baku-MBG-68dca2add2b621e422b3ba81)
    
    ### Contoh Isi Data
    PERHATIAN IMPORT ISI DATA HARAP MENGGUNAKAN MODE ABAIKAN PENGECEKAN KUNCI AGAR PROGRAM BERJALAN MULUS
    [Lihat Contoh Isi Data](https://gist.github.com/alifiharafi/0d842caf727bc2ba2183938b826e87bc)

6.  **Jalankan Aplikasi**
    Terakhir, jalankan server pengembangan bawaan CodeIgniter dengan perintah:
    ```bash
    php spark serve
    ```
    Aplikasi sekarang akan dapat diakses melalui `http://localhost:8080`.

## Credentials untuk Pengujian

Anda dapat menggunakan akun berikut untuk masuk ke dalam sistem dan melakukan pengujian:

### Akun Gudang (Admin)
-   **Username**: `admin`
-   **Password**: `admin`
