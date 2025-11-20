# Admin Panel - Mega Kayan Ganesha

## Instalasi Database

1. Buat database MySQL:
```sql
CREATE DATABASE megakayanganesha CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

2. Import schema database:
```bash
mysql -u root -p megakayanganesha < database/schema.sql
```

3. Konfigurasi koneksi database di `config/database.php`:
```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'megakayanganesha');
```

## Login Admin

- URL: `http://localhost/admin/login.php`
- Username: `admin`
- Password: `admin123`

**PENTING:** Ganti password default setelah login pertama kali!

## Fitur Admin Panel

### 1. Dashboard
- Statistik artikel, lowongan, pelamar, dan pesan kontak
- Artikel dan pelamar terbaru

### 2. Artikel/Berita
- CRUD untuk artikel perusahaan
- Kategori: Artikel, Berita, Pengumuman
- Upload gambar
- Status: Draft/Published

### 3. Jurnal & Inovasi
- CRUD untuk jurnal, inovasi, dan tugas akhir
- Upload file PDF
- Status: Draft/Published

### 4. CSR & Kegiatan Sosial
- CRUD untuk kegiatan CSR
- Kategori: Beasiswa, Lingkungan, Kesehatan, Bencana, Pendidikan, Lainnya
- Upload gambar
- Status: Draft/Published

### 5. Lowongan Pekerjaan
- CRUD untuk lowongan kerja
- Status: Draft/Open/Closed
- Tipe: Full Time, Part Time, Kontrak, Internship

### 6. Pelamar
- Melihat semua lamaran kerja
- Update status: Pending, Review, Interview, Accepted, Rejected
- Download CV dan foto pelamar

### 7. Testimoni
- CRUD untuk testimoni pelanggan
- Kategori: Mekaga Gadai, Mekaga Cocoa, Mekaga Farm, Umum
- Rating 1-5 bintang
- Status: Pending/Approved/Rejected

### 8. Pengajuan Gadai
- Melihat semua pengajuan gadai
- Update status: Pending, Review, Approved, Rejected

### 9. Pemesanan
- Pemesanan Cocoa: Melihat dan update status pemesanan
- Pemesanan Farm: Melihat dan update status pemesanan/kerjasama

### 10. Pesan Kontak
- Melihat semua pesan dari form kontak
- Update status: Unread, Read, Replied, Archived

### 11. Pengaturan
- Mengatur informasi website (nama, email, telepon, alamat)
- Mengatur link media sosial
- Hanya bisa diakses oleh Super Admin

## Struktur Folder Upload

```
uploads/
├── artikel/      # Gambar artikel
├── jurnal/       # File PDF jurnal
├── csr/          # Gambar kegiatan CSR
├── pelamar/      # CV dan foto pelamar
├── pengajuan/    # Foto barang gadai
└── testimoni/    # Foto testimoni
```

## Keamanan

1. Semua form menggunakan prepared statements untuk mencegah SQL injection
2. File upload dibatasi tipe file
3. Password admin di-hash menggunakan bcrypt
4. Session management untuk autentikasi
5. Role-based access control (Super Admin, Admin, Editor)

## Catatan

- Pastikan folder `uploads/` dan subfoldernya memiliki permission 755
- Pastikan PHP memiliki extension `pdo_mysql` dan `gd` (untuk image processing)
- Disarankan untuk mengubah password default admin setelah instalasi

