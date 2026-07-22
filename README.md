# 📦 Stockify

Stockify adalah aplikasi **manajemen persediaan barang (Inventory Management System)** berbasis web yang dikembangkan menggunakan **Laravel 10**. Sistem ini membantu perusahaan dalam mengelola stok barang, transaksi masuk dan keluar, supplier, serta menghasilkan laporan stok secara efisien.

---

## ✨ Fitur Utama

- 🔐 Autentikasi Login
- 👥 Manajemen Pengguna (Admin, Manager, Staff)
- 📦 Manajemen Produk
- 🏷️ Manajemen Kategori
- 🚚 Manajemen Supplier
- 📥 Transaksi Barang Masuk
- 📤 Transaksi Barang Keluar
- 📊 Dashboard Statistik
- 📑 Laporan Transaksi
- 📈 Monitoring Stok
- 📥 Import Data Produk melalui Excel
- 📤 Export Data Produk ke Excel

---

## 🛠️ Teknologi yang Digunakan

### Backend
- Laravel 10
- PHP 8.x
- Eloquent ORM
- Repository Pattern
- Service Layer

### Frontend
- Blade Template
- Tailwind CSS
- Flowbite

### Database
- MySQL

### Package
- Laravel Excel (Maatwebsite)
- Carbon

---

# 🏛️ Arsitektur Sistem

Aplikasi menerapkan **Layered Architecture** dengan pemisahan tanggung jawab pada setiap layer.

```
User
   │
   ▼
Routes
   │
   ▼
Controller
   │
   ▼
Service
   │
   ▼
Repository
   │
   ▼
Model (Eloquent)
   │
   ▼
MySQL Database
```

### Penjelasan

- **Route**
  - Menerima request dari pengguna.
  - Mengarahkan request ke Controller.

- **Controller**
  - Mengelola request dan response.
  - Memanggil Service untuk menjalankan logika bisnis.

- **Service**
  - Berisi seluruh business logic aplikasi.
  - Melakukan validasi data sebelum diproses.

- **Repository**
  - Bertanggung jawab terhadap akses database.
  - Menggunakan Eloquent ORM.

- **Model**
  - Representasi tabel database.

- **View**
  - Menampilkan data kepada pengguna menggunakan Blade.

---

# 🔄 Alur Sistem

## Login

```
User
    │
Input Email & Password
    │
Controller
    │
Authentication
    │
Dashboard
```

---

## Transaksi Barang

```
User
    │
Membuat Transaksi
    │
Controller
    │
Service
    │
Validasi Stok
    │
Repository
    │
Database
    │
Update Stok Produk
```

---

## 📂 Struktur Folder

```
app/
 ├── Http/
 │    └── Controllers/
 │
 ├── Models/
 │
 ├── Services/
 │
 ├── Repositories/
 │
 └── Providers/

resources/
 ├── views/
 ├── css/
 └── js/

routes/
 └── web.php

database/
 ├── migrations/
 └── seeders/

public/

storage/
```

---

# 🗃️ Database

Tabel utama yang digunakan:

- users
- products
- categories
- suppliers
- stock_transactions

Relasi database:

```
Category
      │
      ▼
   Product
      │
      ▼
Stock Transaction
      ▲
      │
     User

Supplier
      │
      ▼
Product
```

---

# 🚀 Instalasi

Clone repository

```bash
git clone https://github.com/username/stockify.git
```

Masuk ke folder project

```bash
cd stockify
```

Install dependency

```bash
composer install
```

Copy file environment

```bash
cp .env.example .env
```

Generate application key

```bash
php artisan key:generate
```

Konfigurasi database pada file `.env`

```env
DB_DATABASE=stockify
DB_USERNAME=root
DB_PASSWORD=
```

Jalankan migration

```bash
php artisan migrate
```

Jika tersedia seeder

```bash
php artisan db:seed
```

Jalankan aplikasi

```bash
php artisan serve
```

Akses aplikasi melalui

```
http://127.0.0.1:8000
```

---

# 👥 Hak Akses

## Admin

- Mengelola User
- Mengelola Produk
- Mengelola Supplier
- Mengelola Kategori
- Mengelola Transaksi
- Import & Export Excel
- Melihat Laporan

---

## Manager

- Melihat Dashboard
- Mengelola Transaksi
- Melihat Laporan
- Monitoring Stok

---

## Staff

- Melihat Dashboard
- Input Barang Masuk
- Input Barang Keluar
- Melihat Produk

---

# 📸 Tampilan Sistem

Berikut halaman utama sistem:

- Login
- Dashboard
- Produk
- Supplier
- Transaksi Barang
- Laporan

*(Tambahkan screenshot pada folder `docs/images` atau `screenshots` jika tersedia.)*

---

# 📌 Keunggulan

- Menggunakan Laravel Framework
- Struktur kode lebih rapi dengan Service & Repository Pattern
- Responsive UI menggunakan Tailwind CSS
- Import dan Export Excel
- Dashboard informatif
- Menggunakan Eloquent ORM
- Mudah dikembangkan

---

# 👨‍💻 Tim Pengembang

- **Ldy**
- **FS**

---

# 📄 Lisensi

Project ini dibuat untuk keperluan pembelajaran dan program magang.
