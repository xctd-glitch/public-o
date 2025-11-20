# Panduan Build & Rebuild

## Ringkasan
- `make build` akan lint seluruh file PHP dan menyiapkan aset hasil salin ke `public_html/assets/dist/`.
- `make clean` membersihkan log/cache yang dihasilkan serta folder build.
- `make rebuild` menjalankan `clean` lalu `build` untuk siklus ulang yang bersih.

## Prasyarat
- PHP 8.1+ tersedia di PATH (gunakan variabel `PHP_BIN` bila perlu memilih binary lain).
- Izin eksekusi untuk skrip di direktori `scripts/` (sudah diset di repo).

## Perintah Utama
```bash
# Lint PHP & siapkan aset
make build

# Bersihkan log/cache & output build
make clean

# Bersihkan lalu build ulang
make rebuild

# Override binary PHP bila tidak default
PHP_BIN=/usr/local/bin/php81 make build
```

Output build akan ditempatkan di `public_html/assets/dist/` (saat ini menyalin `style.css` dari `public_html/assets/`).
