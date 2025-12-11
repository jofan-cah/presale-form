# Form Presale - Laravel 12

Aplikasi Form Presale dengan Laravel 12, QR Code Generator, dan Leaflet.js untuk location picker.

## Features

### Admin Side
- Login manual menggunakan NIP dan Password (tanpa Laravel Breeze)
- **Profil Admin**: Upload/update foto profil, ubah nama, NIP, dan password
- Dashboard untuk melihat semua data form yang masuk
- **Pengaturan Perusahaan**: Upload logo untuk QR Code, ubah nama perusahaan
- Generate QR Code dengan logo perusahaan (format SVG)
- Print dan Download QR Code (format .svg)
- Setiap QR Code memiliki URL unik ke form
- Logo otomatis embed di tengah QR Code
- Logout functionality

### User Side
- Form input sederhana dengan style Google Form
- Field: Nama, Nomor HP, Alamat, Latitude/Longitude
- Location picker menggunakan Leaflet.js dengan fitur geolocation
- Submit tanpa registrasi
- Success message setelah submit
- Responsive design

## Tech Stack

- Laravel 12
- Manual Authentication (tanpa Breeze)
- SimpleSoftwareIO/simple-qrcode untuk QR generation
- Leaflet.js untuk location picker
- Tailwind CSS 4 untuk styling
- MySQL database

## Database Schema

### Table: users
- id (bigint, primary key)
- nip (string, unique) - untuk login
- name (string)
- photo (string, nullable) - foto profil admin
- password (hashed)
- remember_token
- timestamps

### Table: submissions
- id (bigint, primary key)
- nama (string)
- nomor_hp (string)
- alamat (text)
- latitude (string, nullable)
- longitude (string, nullable)
- qr_token (string, nullable, unique)
- timestamps

### Table: qr_codes
- id (bigint, primary key)
- token (string, unique)
- url (text)
- timestamps

### Table: settings
- id (bigint, primary key)
- key (string, unique) - setting key (e.g., 'company_name', 'company_logo')
- value (text, nullable) - setting value
- timestamps

## Setup Instructions

### 1. Install Dependencies

```bash
composer install
npm install
```

### 2. Configure Environment

Copy `.env.example` ke `.env` (sudah ada)

Update konfigurasi database di `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=form_presale
DB_USERNAME=root
DB_PASSWORD=
```

### 3. Create Database

Buat database MySQL dengan nama `form_presale`:

**Opsi 1: Via MySQL Command Line**
```sql
CREATE DATABASE form_presale;
```

**Opsi 2: Via phpMyAdmin**
- Buka phpMyAdmin
- Klik "New" untuk membuat database baru
- Nama database: `form_presale`
- Collation: `utf8mb4_unicode_ci`

### 4. Run Migrations & Seeders

```bash
php artisan migrate:fresh --seed
```

Ini akan membuat:
- Semua tabel yang diperlukan
- Admin default dengan kredensial:
  - **NIP**: 12345
  - **Password**: password

### 5. Build Assets

```bash
npm run build
```

Atau untuk development:
```bash
npm run dev
```

### 6. Start Development Server

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## Default Admin Credentials

- **NIP**: 12345
- **Password**: password

## Routes

### Public Routes
- `/` - Form presale (halaman utama)
- `/form/{token}` - Form presale dengan QR token
- `/success` - Halaman success setelah submit

### Admin Routes
- `/admin/login` - Login admin
- `/admin/dashboard` - Dashboard (protected)
- `/admin/qrcodes` - Kelola QR Code (protected)
- `/admin/profile` - Profil admin - upload foto, ubah data (protected)
- `/admin/settings` - Pengaturan perusahaan - upload logo (protected)
- `/admin/logout` - Logout

## Usage Guide

### Untuk Admin

1. **Login**
   - Buka `http://localhost:8000/admin/login`
   - Masukkan NIP: `12345`
   - Masukkan Password: `password`

2. **Generate QR Code**
   - Di halaman QR Codes, klik "Generate QR Code Baru"
   - QR Code akan dibuat dengan URL unik
   - Setiap QR Code mengarah ke form presale dengan token unik

3. **Download/Print QR Code**
   - Klik tombol "Download" untuk mengunduh QR Code sebagai PNG
   - Klik tombol "Print" untuk mencetak langsung

4. **Lihat Data Submission**
   - Buka Dashboard untuk melihat semua data form yang masuk
   - Data ditampilkan dalam tabel dengan informasi lengkap

### Untuk User

1. **Akses Form**
   - Scan QR Code atau buka URL langsung
   - Isi semua field yang required (Nama, Nomor HP, Alamat)

2. **Set Lokasi**
   - Klik "Gunakan Lokasi Saya" untuk auto-detect lokasi
   - Atau klik pada map untuk memilih lokasi manual
   - Latitude dan Longitude akan terisi otomatis

3. **Submit Form**
   - Klik tombol "Submit Form"
   - Akan diarahkan ke halaman success

## Customization

### Mengubah Lokasi Default Map

Map Leaflet saat ini terfokus di **Klaten, Jawa Tengah** (Lat: -7.7056, Long: 110.6061).

Untuk mengubah lokasi default, edit file `resources/views/form.blade.php` pada baris 98-99:

```javascript
const defaultLat = -7.7056;  // Latitude Klaten
const defaultLng = 110.6061; // Longitude Klaten
```

Contoh lokasi lain:
- **Jakarta**: -6.2088, 106.8456
- **Surabaya**: -7.2575, 112.7521
- **Yogyakarta**: -7.7956, 110.3695
- **Semarang**: -6.9932, 110.4203

Setelah mengubah, rebuild assets:
```bash
npm run build
```

### Upload Foto Profil & Logo Perusahaan

**Foto Profil Admin:**
1. Login sebagai admin
2. Klik "Edit Profil" di bawah nama admin di header
3. Upload foto profil (JPG/PNG, max 2MB)
4. Foto akan muncul di header semua halaman admin

**Logo Perusahaan (untuk QR Code):**
1. Login sebagai admin
2. Klik menu "Pengaturan" di header
3. Upload logo perusahaan (PNG/JPG, rekomendasi 500x500px persegi)
4. Logo akan otomatis embed di tengah QR Code (format SVG)
5. QR Code tetap bisa di-scan meskipun ada logo

**Format QR Code:**
- QR Code menggunakan format **SVG** (Scalable Vector Graphics)
- **Area putih di tengah QR** sebagai background logo (90x90px)
- Logo di-embed sebagai base64 data URL di dalam SVG (80x80px)
- Background putih rounded corners (radius 5px)
- Pattern QR tidak ketabrak dengan logo
- Download: file `.svg` (bisa dibuka di browser/editor SVG)
- Tidak memerlukan extension GD atau Imagick

**Struktur QR dengan Logo:**
```
┌─────────────────────┐
│  QR Pattern         │
│    ┌─────────┐      │
│    │ ⬜ Putih │      │ ← Background putih (90x90)
│    │  🖼️ Logo │      │ ← Logo (80x80)
│    └─────────┘      │
│  QR Pattern         │
└─────────────────────┘
```

**Keuntungan SVG:**
- Bisa di-scale tanpa loss quality
- File size lebih kecil
- Mudah di-edit dengan SVG editor
- Support transparan background
- Logo tidak mengganggu QR pattern

### Mengubah Styling

Semua views menggunakan Tailwind CSS. Edit file di folder `resources/views/` untuk mengubah tampilan.

## Troubleshooting

### Error: "could not find driver (Connection: sqlite)"
Ganti DB_CONNECTION di .env dari `sqlite` ke `mysql` dan buat database MySQL.

### Error: "SQLSTATE[HY000] [1049] Unknown database"
Pastikan database `form_presale` sudah dibuat di MySQL.

### Error: "SQLSTATE[HY000] [2054] The server requested authentication method"
Update password MySQL user dengan:
```sql
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '';
FLUSH PRIVILEGES;
```

### QR Code tidak muncul
Pastikan package `simplesoftwareio/simple-qrcode` sudah terinstall:
```bash
composer require simplesoftwareio/simple-qrcode
```

## File Structure

```
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── LoginController.php      # Manual login/logout
│   │   │   ├── DashboardController.php  # Admin dashboard
│   │   │   ├── FormController.php       # User form
│   │   │   └── QrController.php         # QR code management
│   │   └── Middleware/
│   │       └── CheckAdmin.php           # Manual auth middleware
│   └── Models/
│       ├── User.php                     # User model (NIP-based)
│       ├── Submission.php               # Form submission model
│       └── QrCode.php                   # QR code model
├── database/
│   ├── migrations/                      # Database migrations
│   └── seeders/
│       └── AdminSeeder.php              # Seed default admin
├── resources/
│   ├── views/
│   │   ├── admin/
│   │   │   ├── login.blade.php
│   │   │   ├── dashboard.blade.php
│   │   │   └── qrcodes.blade.php
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── form.blade.php
│   │   └── success.blade.php
│   └── css/
│       └── app.css                      # Tailwind CSS
└── routes/
    └── web.php                          # All application routes
```

## Security Notes

- Password di-hash menggunakan bcrypt
- Session-based authentication
- CSRF protection pada semua form
- Input validation pada semua request
- Middleware untuk protect admin routes

## Development Notes

- Gunakan `npm run dev` untuk hot reload saat development
- Gunakan `npm run build` untuk production build
- Laravel 12 sudah include Tailwind CSS 4 by default

## License

Open-sourced software.
