# JASIKOS — Panduan Instalasi Pengembangan Lokal

> **Cakupan:** Dokumen ini sengaja difokuskan untuk **pengujian lokal saja**.

---

## Tentang Aplikasi & Alur Bisnis

**JASIKOS** adalah platform pemesanan jasa desain dengan dua alur utama:

* **Beli dari Katalog** — pelanggan membeli produk desain yang sudah tersedia.
* **Permintaan Khusus (Custom Request)** — pelanggan meminta desain baru dari desainer tertentu atau acak.

**Pembayaran**: melalui transfer bank/QRIS (pelanggan mengunggah bukti pembayaran).  
**Deliverables**: Digital atau Kirim (paket fisik).  
**Fitur inti**: alur revisi, deliverables dengan aturan akses, riwayat status, serta penilaian/ulasan desainer.

---

## 1) Ringkasan Teknis

**Framework:** Laravel 10  
**PHP:** ≥ 8.1  
**DB:** MySQL/MariaDB  
**Auth/API:** Laravel Sanctum  
**UI/Scaffold (opsional):** Laravel Breeze (dev)  
**HTTP Client:** guzzlehttp/guzzle  
**Alert:** realrashid/sweet‑alert  
**Frontend Build:** Vite (Node.js & NPM)

> Mengacu pada `composer.json`: `php:^8.1`, `laravel/framework:^10.10`, `laravel/sanctum:^3`, `laravel/breeze:^1` (dev), `realrashid/sweet-alert:^7`.

---

## 2) Persyaratan

Pasang hal‑hal berikut sebelum mulai:

* **PHP 8.1+** dengan ekstensi umum: `pdo_mysql`, `mbstring`, `openssl`, `ctype`, `json`, `tokenizer`, `xml`, `curl`, `fileinfo`, `bcmath`, `intl`, `zip`.
* **Composer** 2.x
* **MySQL/MariaDB**
* **Node.js (LTS)** & **npm**
* (Opsional) **Git**

> **Windows (XAMPP):** pastikan `ext-zip` diaktifkan di `php.ini`.  
> **Linux:** pastikan `storage/` dan `bootstrap/cache/` dapat ditulis oleh web server.

---

## 3) Mulai Cepat (Local Dev)

```bash
# 1) Clone & masuk folder proyek
git clone <REPO_URL> jasikos && cd jasikos

# 2) Instal dependensi
composer install
npm install

# 3) Salin env & generate key
cp .env.example .env      # Windows: copy .env.example .env
php artisan key:generate

# 4) Konfigurasi DB di .env, lalu migrate (dan seed jika tersedia)
php artisan migrate --seed

# 5) Buat symlink storage & jalankan server dev
php artisan storage:link
php artisan serve          # http://127.0.0.1:8000
npm run dev                # jalankan Vite (hot reload)
```

---

## 4) Langkah Lengkap (Local Dev)

### 4.1 Clone Repository

```bash
git clone <REPO_URL> jasikos
cd jasikos
```

### 4.2 Instal Dependensi

```bash
composer install
npm install
```

### 4.3 Penyiapan Environment

Buat `.env` dari contoh:

```bash
cp .env.example .env   # Windows: copy .env.example .env
```

Edit nilai‑nilai kunci (contoh aman):

```env
APP_NAME="JASIKOS"
APP_ENV=local
APP_KEY=              # akan diisi oleh key:generate
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=jasikos
DB_USERNAME=root
DB_PASSWORD=

# Mail (Mailtrap untuk pengujian lokal)
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=xxxx
MAIL_PASSWORD=xxxx
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@jasikos.test
MAIL_FROM_NAME="JASIKOS"

# Queue & Cache default
QUEUE_CONNECTION=sync
CACHE_DRIVER=file
SESSION_DRIVER=file
FILESYSTEM_DISK=public
```

Generate key:

```bash
php artisan key:generate
```

### 4.4 Database & Migrasi

Buat database kosong (mis. `jasikos`), lalu jalankan:

```bash
php artisan migrate --seed   # gunakan --seed jika ada seeder
```

### 4.5 Storage & Upload File

```bash
php artisan storage:link
```

### 4.6 Build Frontend (Vite)

* Mode pengembangan: `npm run dev`
* *(Abaikan build produksi pada dokumen ini)*

### 4.7 Jalankan Aplikasi

```bash
php artisan serve   # http://127.0.0.1:8000
```

> Jika proyek men‑seed akun admin/default, lihat **Akun Awal** di bawah.

---

## 5) Tutorial Mailtrap (Pengujian Email Lokal)

Mailtrap memungkinkan Anda menguji email tanpa mengirimnya ke inbox asli.

### 5.1 Buat Inbox & Ambil Kredensial

1. Masuk ke **mailtrap.io**.
2. Buka **Email Testing → Inboxes** dan pilih/buat inbox.
3. Buka **Integrations** (atau **SMTP Settings**), pilih **Laravel** untuk melihat kredensial SMTP (host, port, username, password).\n\n   * `MAIL_USERNAME` = nilai *Username* yang ditampilkan.  \n   * `MAIL_PASSWORD` = nilai *Password* yang ditampilkan.  \n   * `MAIL_HOST` umumnya `sandbox.smtp.mailtrap.io`.  \n   * `MAIL_PORT` umumnya `2525` (atau 587).

### 5.2 Masukkan Kredensial ke `.env`

Salin ke `.env` Anda:

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_mailtrap_user
MAIL_PASSWORD=your_mailtrap_pass
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=no-reply@jasikos.test
MAIL_FROM_NAME="JASIKOS"
```

Refresh konfigurasi:

```bash
php artisan config:clear
```

### 5.3 Kirim Email Uji Coba (Sederhana)

**Opsi A — route cepat (lokal saja):**

```php
// routes/web.php
use Illuminate\Support\Facades\Mail;

Route::get('/test-mail', function () {
    Mail::raw('Hello from JASIKOS (Mailtrap test).', function ($m) {
        $m->to('receiver@example.com')->subject('JASIKOS Test Email');
    });
    return 'Email test terkirim (cek Mailtrap).';
});
```

Buka `http://127.0.0.1:8000/test-mail` dan cek inbox Mailtrap.

**Opsi B — via Tinker:**

```bash
php artisan tinker
>>> Mail::raw('Test via Tinker', function($m){ $m->to('receiver@example.com')->subject('Test'); });
```

> Catatan: `QUEUE_CONNECTION=sync` sudah cukup untuk pengujian lokal.

### 5.4 End‑to‑End: Kirim Email **Reset Password**

Uji alur **Lupa Password** lengkap dan pastikan email reset masuk ke Mailtrap.

**Langkah 1 — Seed user dummy** (jika belum ada):

```php
// routes/web.php
use App\Models\User;
use Illuminate\Support\Facades\Hash;

Route::get('/seed-test-user', function(){
    $user = User::firstOrCreate(
        ['email' => 'client@test.local'],
        ['name' => 'Client Test', 'password' => Hash::make('password')]
    );
    return 'User siap: ' . $user->email;
});
```

Kunjungi `http://127.0.0.1:8000/seed-test-user` satu kali.

**Langkah 2 — Picu link reset secara programatis** (tanpa UI):

```php
// routes/web.php
use Illuminate\Support\Facades\Password;

Route::get('/test-reset', function(){
    $email = 'client@test.local';
    $status = Password::sendResetLink(['email' => $email]);
    return $status === Password::RESET_LINK_SENT
        ? 'Reset link terkirim ke Mailtrap untuk ' . $email
        : 'Gagal mengirim reset link: ' . __($status);
});
```

Kunjungi `http://127.0.0.1:8000/test-reset` → Anda akan melihat **Reset link terkirim** bila sukses.

**Langkah 3 — Verifikasi di Mailtrap**

1. Buka inbox yang sama.
2. Cek **Messages** untuk email baru — subjek biasanya **“Reset Password Notification”**.
3. Klik email → gunakan tab **HTML** untuk tampilan normal, **Text** untuk teks polos, atau **Raw** untuk header.
4. Body berisi **tautan reset** (dengan token). Jika UI auth (Breeze/Fortify) belum dipasang, tautan ini bisa 404 — tidak masalah untuk pengujian **pengiriman email**.

**Opsional — Gunakan Breeze UI**  
Jika repo sudah memakai Breeze, buka `http://127.0.0.1:8000/forgot-password`, masukkan `client@test.local`, submit, lalu cek Mailtrap.  
Jika belum terpasang tetapi ingin mencoba cepat:

```bash
php artisan breeze:install blade
npm install && npm run dev
php artisan migrate
```

Ini akan menyediakan route `/forgot-password`.

---

## 6) Catatan Paket & Fitur

* **Laravel Sanctum** — pastikan tabelnya termigrasi. Untuk SPA/cookie lintas subdomain, nanti set `SESSION_DOMAIN` & `SANCTUM_STATEFUL_DOMAINS` di panduan produksi.
* **realrashid/sweet‑alert** — auto‑discovery. Jika perlu publish:
  ```bash
  php artisan vendor:publish --provider="RealRashid\\SweetAlert\\SweetAlertServiceProvider"
  ```
* **Laravel Breeze (dev)** — hanya scaffolding. Jika UI sudah ada di repo, tidak perlu pasang ulang.

---

## 7) Perintah Sehari‑hari

```bash
php artisan serve          # jalankan server lokal
npm run dev                # jalankan Vite (hot reload)
php artisan migrate        # jalankan migrasi DB
php artisan db:seed        # isi data demo (jika ada)
php artisan tinker         # REPL untuk uji cepat
php artisan optimize:clear # bersihkan config/route/view/cache
```

---

## 8) Pemecahan Masalah (Lokal)

* **HTTP 500 setelah setup** → periksa ekstensi PHP & izin pada `storage/` dan `bootstrap/cache/`.
* **No application encryption key specified** → `php artisan key:generate` dan pastikan `APP_KEY` ada di `.env`.
* **Class not found / autoload error** → `composer install` lalu `php artisan optimize:clear`.
* **Assets (CSS/JS) tidak muncul** → pastikan `npm run dev` berjalan; cek `APP_URL` (hindari campur http/https).
* **MySQL “Access denied”** → cek `DB_USERNAME/DB_PASSWORD/DB_HOST`; pastikan database ada.
* **Email tidak muncul di Mailtrap** → verifikasi `MAIL_USERNAME/PASSWORD` dari inbox aktif dan jalankan `php artisan config:clear`.

---

## 9) Akun Awal (Opsional)

> Jika repo menyertakan seeder admin/demo, cantumkan di sini (hapus dari README publik jika sensitif):

```
Email: admin@jasikos.test
Password: password
```

---

## 10) Skrip Composer (Otomasi)

Dari `composer.json`:

* `post-root-package-install` → menyalin `.env` jika belum ada.
* `post-create-project-cmd` → menjalankan `php artisan key:generate`.

Umumnya Anda cukup menjalankan:

```bash
composer install
php artisan key:generate
```

---

## 11) Kontak

Untuk pertanyaan atau dukungan implementasi:

* Email: [support@jasikos.test](mailto:support@jasikos.test) (contoh)
* Author: (isi nama/tautan)
