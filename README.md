# E-Transit

E-Transit adalah aplikasi PHP native + MySQL untuk monitoring dan manajemen ruang transit rumah sakit.

## Menjalankan di XAMPP

1. Pastikan Apache dan MySQL XAMPP aktif.
2. Dari folder project, jalankan:

```bash
php database/setup.php
```

3. Buka:

```text
http://localhost/project_web/
```

## Akun awal

- Admin: `admin` / `Admin@123`
- Perawat IGD: `igd` / `Igd@1234`
- Perawat Transit: `transit` / `Transit@123`

## Tema Terang dan Gelap

Toggle matahari/bulan tersedia pada header semua halaman Admin, Perawat
IGD, dan Perawat Transit, serta halaman login/register. Pilihan tersimpan
di browser dan disinkronkan antar-tab. Jika belum memilih tema, aplikasi
mengikuti pengaturan tema sistem. Tema diterapkan sebelum halaman tampil
untuk menghindari kilatan warna terang. Pengaturan tema tidak memerlukan
migrasi database.

## Animasi Sidebar

Menu Admin, Perawat IGD, dan Perawat Transit memiliki efek kilau saat
diklik, gerakan ikon, serta penanda menu aktif yang bergeser. Efek ringan
berlangsung 140-240 ms hanya pada elemen sidebar, mengikuti kedua tema.
Klik langsung membuka halaman; konten dan formulir tetap stabil serta
dapat digunakan selama efek sidebar berjalan. Navigasi mendukung
keyboard/tab baru dan preferensi pengurangan gerakan pada perangkat.

## Denah Bed di Dashboard

Dashboard ketiga role menampilkan denah kecil dengan susunan bed seperti
kursi bioskop. Nama kelompok kamar mengikuti Ruang Transit: 1A-1F,
2A-2F, 4A-4C, 5A-5B, dan Isolasi. Bed kosong berwarna hijau, terisi
merah, siap transfer biru, dan nonaktif abu-abu. Kode bed serta legenda
status tetap tersedia pada tema terang/gelap dan layar ponsel.
Denah mengikuti pembaruan status otomatis setiap 15 detik tanpa reload.

## Konfigurasi database

Default database: `e_transit`, user `root`, password kosong. Jika berbeda, set environment variable:

```text
DB_HOST
DB_PORT
DB_DATABASE
DB_USERNAME
DB_PASSWORD
```

## Memperbarui Database Yang Sudah Ada

Untuk menambahkan kolom baru tanpa reset atau mengisi ulang data awal:

```powershell
C:\xampp\php\php.exe database/migrate.php
```

Migrasi dapat dijalankan berulang tanpa membuat kolom duplikat. Data pasien
lama tetap dipertahankan; kolom administrasi baru boleh kosong jika belum
tersedia. Form baru menyimpan identitas, agama, penanggung pasien, kelas,
penanggung jawab, hubungan, nomor HP, dan pendidikan ke tabel `patients`.

## Menyesuaikan Daftar Bed

Daftar awal berisi 19 bed: `1A` sampai `1F`, `2A` sampai `2F`,
`4A` sampai `4C`, `5A` dan `5B`, serta `Iso A` dan `Iso B`.
Pengelompokan di `config/app.php` digunakan oleh Ruang Transit dan
Monitor IGD, termasuk ringkasan status tiap kelompok saat polling.

Untuk database yang sudah berjalan, buat backup lalu periksa rencana:

```powershell
C:\xampp\php\php.exe database/update_beds.php --dry-run
```

Terapkan hanya setelah rencana sesuai:

```powershell
C:\xampp\php\php.exe database/update_beds.php --apply
```

Bed yang kodenya sudah sesuai tidak diubah. Bed lama dipakai ulang dengan
ID dan status yang sama; hanya bed kosong/nonaktif tanpa relasi pasien
atau transfer yang boleh dihapus. Jika daftar tidak dapat disesuaikan
tanpa menghilangkan relasi pasien, seluruh transaksi dibatalkan.
Skrip ini tidak dijalankan otomatis oleh migrasi kolom database.
