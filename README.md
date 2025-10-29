# Sistem Informasi Akademik Mahasiswa

Sistem Informasi Akademik Mahasiswa adalah aplikasi web yang dibangun dengan Laravel untuk mengelola data akademik mahasiswa, dosen, mata kuliah, dan proses akademik lainnya.

## Fitur Utama

- **Manajemen Pengguna:** Mengelola pengguna dengan peran yang berbeda (Admin, Dosen, Mahasiswa).
- **Manajemen Data Master:**
    - CRUD untuk data Mahasiswa
    - CRUD untuk data Dosen
    - CRUD untuk data Mata Kuliah
- **Manajemen Akademik:**
    - **Jadwal Kuliah:** Pengelolaan jadwal perkuliahan.
    - **Kartu Rencana Studi (KRS):** Mahasiswa dapat mengisi KRS, dan Dosen Pembimbing Akademik dapat menyetujui atau menolaknya.
    - **Kartu Hasil Studi (KHS):** Mahasiswa dapat melihat hasil studi mereka per semester.
    - **Nilai:** Dosen dapat memasukkan nilai untuk mahasiswa.
- **Notifikasi:** Pengguna menerima notifikasi untuk pembaruan penting (misalnya, persetujuan KRS, pengumuman baru).
- **Pengumuman:** Admin dapat membuat pengumuman yang dapat dilihat oleh semua pengguna.
- **Laporan:**
    - Mahasiswa dapat mencetak KRS, KHS, dan Transkrip Nilai.
    - Admin dapat mencetak laporan akademik untuk setiap mahasiswa.
- **Halaman Kontak:** Formulir bagi pengguna untuk mengirim pesan atau pertanyaan.

## Peran Pengguna (Roles)

Aplikasi ini memiliki tiga peran pengguna utama:

1.  **Admin:**
    - Memiliki akses penuh ke semua fitur manajemen.
    - Dapat mengelola data pengguna, mahasiswa, dosen, dan mata kuliah.
    - Dapat membuat pengumuman.
    - Dapat mengelola jadwal kuliah.

2.  **Dosen:**
    - Dapat mereview dan menyetujui/menolak KRS mahasiswa perwaliannya.
    - Dapat memasukkan nilai untuk mata kuliah yang diampu.
    - Dapat melihat daftar mahasiswa yang mengambil mata kuliahnya.

3.  **Mahasiswa:**
    - Dapat mengisi dan mengajukan KRS.
    - Dapat melihat Kartu Hasil Studi (KHS).
    - Dapat melihat jadwal kuliah.
    - Dapat mencetak laporan (KRS, KHS, Transkrip).

## Instalasi

1.  **Clone repository:**
    ```bash
    git clone https://github.com/your-username/manajemen_mahasiswa.git
    cd manajemen_mahasiswa
    ```

2.  **Install dependencies:**
    ```bash
    composer install
    npm install
    ```

3.  **Setup environment:**
    - Salin file `.env.example` menjadi `.env`.
    - Buat database baru untuk aplikasi.
    - Konfigurasikan koneksi database di file `.env`.
    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Jalankan migrasi dan seeder:**
    ```bash
    php artisan migrate:fresh --seed
    ```

5.  **Jalankan server development:**
    ```bash
    php artisan serve
    npm run dev
    ```

## Penggunaan

Setelah menjalankan `migrate:fresh --seed`, akun admin default akan dibuat:

-   **Email:** `admin@gmail.com`
-   **Password:** `password`

-   **Email:** `mahasiswa1@gmail.com`
-   **Password:** `mahasiswa1`

-   **Email:** `(lihat di data base admin, lihat urutannya)`
-   **Password:** `dosen001 (Sesuai urutan admin)`