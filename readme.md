# 🖥️ Monitoring Jaringan LAB SD

Sistem Monitoring Jaringan LAB SD adalah aplikasi berbasis web yang dibangun menggunakan Laravel. Sistem ini memungkinkan administrator sekolah untuk memantau status jaringan di laboratorium komputer SD, mendeteksi perangkat yang terhubung, serta memantau kestabilan koneksi menggunakan Mikrotik sebagai router utama.

## 🚀 Fitur Utama
✅ **Dashboard Real-time** – Menampilkan informasi status jaringan secara langsung.  
✅ **Monitoring Perangkat** – Menampilkan daftar perangkat yang terhubung ke jaringan.  
✅ **Statistik Penggunaan Jaringan** – Melihat data penggunaan bandwidth.  
✅ **Notifikasi Gangguan** – Memberikan peringatan jika ada masalah pada jaringan.  
✅ **Log Aktivitas** – Menyimpan catatan perubahan status jaringan untuk analisis.  
✅ **Integrasi Mikrotik** – Menggunakan API Mikrotik untuk mendapatkan informasi perangkat dan trafik.  

---

## ⚙️ Teknologi yang Digunakan
- **Backend:** Laravel 10
- **Database:** PgSql
- **Frontend:** Bootstrap
- **Networking:** Mikrotik API

---

## 📌 Persyaratan Sistem
Sebelum memulai, pastikan perangkat Anda memenuhi spesifikasi berikut:

- PHP >= 8.1
- Composer
- MySQL atau MariaDB
- Node.js & NPM (untuk frontend assets)
- Mikrotik Router dengan API service aktif

---

## 🔧 Cara Instalasi

### 1️⃣ Clone Repository
```bash
git clone https://github.com/username/repo-monitoring-jaringan-lab.git
cd repo-monitoring-jaringan-lab
