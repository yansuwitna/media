# Rancangan Aplikasi Rencana Media

Dokumen ini berisi spesifikasi arsitektur, basis data, alur autentikasi multi-tabel, dan antarmuka untuk aplikasi manajemen rencana media.

---

## 1. Arsitektur & Teknologi

- **Backend**: Laravel (PHP)
- **Frontend**: Vue.js 3 + Inertia.js (atau Blade + Vue Components)
- **Styling**: Tailwind CSS (Dark/Light mode support) + Font Poppins
- **UI Notifications**: SweetAlert2
- **Database**: MySQL (`localhost`, user: `admin`, password: `Admin!`, database: `media_db`)

---

## 2. Struktur Basis Data (Multi-Table & Relasi)

### A. Tabel Autentikasi Pengguna (3 Peran / Multi-Tabel)

1. **`users` / `superadmins`** (Pengguna Utama):
   - `id` (PK)
   - `name` (VARCHAR)
   - `email` (VARCHAR, UNIQUE)
   - `password` (VARCHAR)
   - `created_at`, `updated_at`

2. **`admins`** (Admin):
   - `id` (PK)
   - `name` (VARCHAR)
   - `username` / `email` (VARCHAR, UNIQUE)
   - `password` (VARCHAR)
   - `created_at`, `updated_at`

3. **`operators`** (Operator):
   - `id` (PK)
   - `name` (VARCHAR)
   - `username` / `email` (VARCHAR, UNIQUE)
   - `password` (VARCHAR)
   - `created_by_admin_id` (FK -> admins.id, nullable)
   - `created_at`, `updated_at`

---

### B. Tabel Konfigurasi & Operasional

4. **`web_identities`** (Identitas Website - dikelola Admin):
   - `id` (PK)
   - `app_name` (VARCHAR)
   - `app_description` (TEXT, nullable)
   - `logo_path` (VARCHAR, nullable)
   - `favicon_path` (VARCHAR, nullable)
   - `footer_text` (VARCHAR, nullable)
   - `theme_default` (ENUM: 'light', 'dark')

5. **`upload_locations`** (Lokasi Upload Media - dikelola Operator):
   - `id` (PK)
   - `name` (VARCHAR) (contoh: YouTube, Instagram, TikTok, Website, Drive)
   - `url` (VARCHAR, nullable)
   - `description` (TEXT, nullable)
   - `operator_id` (FK -> operators.id)
   - `created_at`, `updated_at`

6. **`projects`** (Proyek Rencana Media):
   - `id` (PK)
   - `operator_id` (FK -> operators.id)
   - `title` (VARCHAR)
   - `description` (TEXT, nullable)
   - `target_date` (DATE, nullable)
   - `status` (ENUM: 'draft', 'in_progress', 'completed', 'cancelled')
   - `created_at`, `updated_at`

7. **`project_details`** (Rincian Proyek):
   - `id` (PK)
   - `project_id` (FK -> projects.id, CASCADE)
   - `upload_location_id` (FK -> upload_locations.id, RESTRICT/SET NULL)
   - `item_name` (VARCHAR) (contoh: Video Teaser, Poster 1, Reel)
   - `media_type` (ENUM: 'video', 'image', 'audio', 'article', 'other')
   - `notes` (TEXT, nullable)
   - `status` (ENUM: 'pending', 'ready', 'uploaded')
   - `created_at`, `updated_at`

---

## 3. Skema Multi-Table Authentication di Laravel

Konfigurasi `config/auth.php`:
```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],
    'admin' => [
        'driver' => 'session',
        'provider' => 'admins',
    ],
    'operator' => [
        'driver' => 'session',
        'provider' => 'operators',
    ],
],

'providers' => [
    'users' => [
        'driver' => 'eloquent',
        'model' => App\Models\User::class,
    ],
    'admins' => [
        'driver' => 'eloquent',
        'model' => App\Models\Admin::class,
    ],
    'operators' => [
        'driver' => 'eloquent',
        'model' => App\Models\Operator::class,
    ],
],
```

---

## 4. Struktur Halaman & Navigasi

1. **Halaman Publik / Home (`/`)**:
   - Card Statistik: Total Proyek Rencana Media, Proyek Selesai, Proyek Berjalan.
   - Tombol / Form Login terpisah sesuai peran (Admin & Operator).

2. **Dashboard Admin (`/admin/dashboard`)**:
   - **Sidebar Kiri**:
     - Dashboard
     - Identitas Web (Form ubah nama web, logo, footer)
     - Manajemen Operator (Tambah, edit, hapus user operator)
     - Logout
   - SweetAlert2 untuk konfirmasi dan respon status.

3. **Dashboard Operator (`/operator/dashboard`)**:
   - **Sidebar Kiri**:
     - Dashboard & Ringkasan
     - Lokasi Upload (CRUD tujuan upload)
     - Proyek Media (Tambah & daftar proyek)
     - Rincian Proyek (Kelola rincian item dalam proyek)
     - Logout

---

## 5. Panduan Desain UI/UX

- **Typography**: Google Font `Poppins`.
- **Mode Tampilan**: Dark & Light mode toggle.
  - Light: Elegan dengan palet slate/zinc lembut.
  - Dark: Modern dengan palet background gelap beraksen rapi.
- **Notifikasi**: SweetAlert2 tema modern terintegrasi.
