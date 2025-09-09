# Formify API

**Formify** adalah aplikasi manajemen formulir sederhana yang dibangun dengan **Laravel API** untuk membantu Anda membuat, mengelola, dan melacak tanggapan formulir. Aplikasi ini dirancang untuk kemudahan penggunaan, memungkinkan Anda membuat berbagai jenis formulir dengan pertanyaan berbeda, mengumpulkan tanggapan, dan melihat hasilnya dengan mudah.

---

## Fitur Utama

-   **Manajemen Formulir**: Buat, edit, dan hapus formulir baru dengan mudah.
-   **Jenis Pertanyaan Beragam**: Tambahkan berbagai jenis pertanyaan ke formulir Anda, seperti teks, pilihan ganda, kotak centang (checkbox), dan lainnya.
-   **Pengumpulan Tanggapan**: Biarkan pengguna menjawab formulir secara daring (online) dan simpan tanggapan mereka langsung ke database.
-   **Penampil Tanggapan**: Lihat semua tanggapan yang masuk dalam satu dasbor yang rapi.

---

## Persyaratan Sistem

-   PHP >= 8.2
-   MySQL
-   Composer

---

## Instalasi

1.  **Kloning Repositori:**
    ```bash
    git clone https://github.com/ishomnt/formify-api.git
    cd formify-api
    ```

2.  **Instal Dependensi Composer:**
    ```bash
    composer install
    ```

3.  **Konfigurasi Environment:**
    -   Salin file `.env.example` menjadi `.env`:
        ```bash
        cp .env.example .env
        ```
    -   Buka file `.env` dan konfigurasikan koneksi database MySQL Anda.

        ```env
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=formify_db
        DB_USERNAME=root
        DB_PASSWORD=
        ```

    -   Ganti `formify_db`, `root`, dan `password` dengan detail database Anda.

4.  **Jalankan Migrasi dan Seeder:**
    ```bash
    php artisan migrate --seed
    ```

5.  **Buat Kunci Aplikasi:**
    ```bash
    php artisan key:generate
    ```

6.  **Jalankan Server Lokal:**
    ```bash
    php artisan serve
    ```

Aplikasi sekarang akan berjalan di `http://127.0.0.1:8000`.

---

## Penggunaan

-   **Dashboard Admin:** Akses dashboard admin untuk membuat, mengelola, dan melihat formulir.
-   **Tautan Formulir:** Setelah membuat formulir, Anda akan mendapatkan tautan yang dapat dibagikan kepada pengguna untuk menjawabnya.
-   **Lihat Tanggapan:** Di dashboard admin, pilih formulir untuk melihat semua tanggapan yang telah masuk.

---

## Lisensi

Proyek ini dilisensikan di bawah **Lisensi MIT**. Lihat file `LICENSE` untuk detail lebih lanjut.

---

## Kontribusi

Kontribusi dipersilakan! Jika Anda ingin berkontribusi, silakan buat *pull request* atau buka *issue* jika Anda menemukan *bug* atau memiliki ide untuk fitur baru.
