# Sistem Prediksi Kunjungan Wisata Bunihayu (SARIMA)

Proyek ini adalah implementasi sistem cerdas berbasis *Machine Learning* untuk memprediksi jumlah kunjungan wisata di Wana Wisata Kampoeng Ciherang Bunihayu menggunakan algoritma SARIMA (Seasonal Autoregressive Integrated Moving Average) dengan frontend Laravel dan microservice Python Flask.

---

## 🏗️ Struktur Repositori

- `/ml-sarima/` - Direktori Machine Learning Module (Python/Flask API).
- `/website/` - Direktori Aplikasi Web Utama (Laravel 11).
- `uml_diagrams.md` - Dokumentasi proses sistem (Use Case, Activity Diagram).

---

## 🚀 Cara Menjalankan Project

Untuk menjalankan project ini di komputer (localhost/XAMPP), pastikan Anda menjalankan 2 server secara bersamaan:

### 1. Menjalankan Python ML API Server

Server python bertindak sebagai "otak" untuk memberikan prediksi dan data grafik kepada website Laravel.

1. Buka terminal (CMD/Powershell) dan masuk ke folder ml:
   ```bash
   cd ml-sarima
   ```
2. Instal pustaka yang dibutuhkan (disarankan menggunakan *Virtual Environment*):
   ```bash
   pip install -r requirements.txt
   ```
3. Jalankan server Flask:
   ```bash
   python src/api.py
   ```
   > Service akan berjalan secara default di `http://127.0.0.1:5000`

### 2. Menjalankan Website Laravel

Website bertindak sebagai "wajah" (Dashboard User/Admin).

1. Buka terminal baru dan masuk ke folder website:
   ```bash
   cd website
   ```
2. Siapkan file konfigurasi `.env` dan install dependency:
   ```bash
   composer install
   npm install
   npm run build
   ```
   > **Catatan**: Jika file `.env` belum ada, salin dari `.env.example` atau buat file baru.

3. Konfigurasi Aplikasi & Hubungkan ke Backend:
   *   **Generate App Key**:
       ```bash
       php artisan key:generate
       ```
   *   **Hubungkan ke Backend Python**: Buka file `.env`, pastikan baris `SARIMA_API_URL` mengarah ke URL Flask (default: `http://127.0.0.1:5000`):
       ```env
       SARIMA_API_URL=http://127.0.0.1:5000
       ```

4. Jalankan Migrasi & Seeding Database:
   Aplikasi ini menggunakan SQLite secara default untuk kemudahan development.
   ```bash
   php artisan migrate
   php artisan db:seed
   ```
   > Ini akan membuat tabel yang diperlukan dan mendaftarkan akun admin default:
   > - **Email**: `admin@bunihayu.com`
   > - **Password**: `password`
5. *Start server* aplikasi web Laravel:
   ```bash
   php artisan serve
   ```
   > Buka browser ke alamat `http://127.0.0.1:8000`

---

## 📊 Fitur Utama

**Landing Page**: UI modern ala portal resort alam dengan tombol Login/Register.
**Overview Dashboard**: Menampilkan kalkulasi pengunjung bulan lalu, serta prediksi kunjugan bulan depan.
**Prediksi SARIMA**: Menampilkan perpaduan visual grafik data historis bersama zona interval kepercayaan 95% untuk bulan ke depannya. Serta mendetailkan error metrik (RMSE, MAE, MAPE).
**Analisis Trend**: Pemecahan visual berbasis pie-chart (Traffic Level) dan garis mingguan agar manajemen tau mana hari padat wisata.
**Laporan Data**: Ringkasan lengkap tabel komparasi pengunjung KTM dan Glamping per bulannya.

---
*Created as Joki Project Output - 2024/2026*
