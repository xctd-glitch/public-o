# Smart Redirect Platform (SRP)

Platform redirect cerdas untuk mengarahkan trafik berdasarkan device, negara, dan status VPN. Dashboard login membantu mengatur konfigurasi dengan aman tanpa mengubah kode secara manual.

## Fitur Utama
- Dashboard login dengan proteksi sesi dan CSRF.
- Decision engine: filter negara whitelist/blacklist, deteksi device, dan dukungan mute/unmute.
- Manajemen konfigurasi environment via UI (DB, API key, rate limit, dsb).
- Postback logging dan agregasi payout dasar.
- Skrip cron pembersih log (lihat `cron_cleanup_logs.php`).

## Struktur Singkat
```
public_html/     # Endpoint publik (index/login/data/decision/postback)
src/             # MVC: Controllers, Models, Views, Middleware, Config
docs/            # Panduan build, migrasi, dan refactoring
scripts/         # Skrip build/clean pendukung
```

## Cara Jalan Cepat
1) Salin dan sesuaikan variabel di `.env` (lihat kunci yang digunakan di `src/Models/EnvConfig.php`).
2) Pointing web server ke `public_html/` (Apache/Nginx contoh di `docs/README_NEW_STRUCTURE.md`).
3) Masuk ke `/login.php`, lalu gunakan tab konfigurasi untuk mengatur API key, DB, dan redirect URL.

## Dokumentasi Lengkap
- `docs/README_NEW_STRUCTURE.md` – panduan instalasi dan server.
- `docs/BUILD.md` – cara build aset CSS/JS.
- `docs/MIGRATION_GUIDE.md` – langkah migrasi dari struktur lama.
- `docs/STRUCTURE_DIAGRAM.md` – diagram arsitektur aplikasi.

## Catatan
- Skrip legacy `r.php` sudah dihapus karena routing kini ditangani lewat `public_html/decision.php` dan controller MVC.
