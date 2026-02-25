# Product Specification: PONSPES
## Sistem Informasi Pondok Pesantren Pancasila Reo

**Version:** 1.0  
**Last Updated:** January 2026  
**Status:** Production Ready (~92%)

---

## 1. Overview

PONSPES is a comprehensive School Management System (SMS) designed specifically for Pondok Pesantren (Islamic Boarding Schools). It provides end-to-end management of academic, financial, and administrative operations.

### 1.1 Tech Stack

| Layer | Technology |
|-------|------------|
| **Framework** | Laravel 11 |
| **Frontend** | Blade + Livewire 3 + Alpine.js |
| **Styling** | Tailwind CSS |
| **Database** | MySQL 8.0 |
| **Authentication** | Laravel Breeze |
| **Build Tools** | Vite |
| **PWA** | Custom Service Worker |

---

## 2. User Roles & Access Control

| Role | Access Level | Description |
|------|--------------|-------------|
| **Admin** | Full | Complete system access |
| **Operator** | Limited | Data management, no CMS/backup |
| **Guru** | Portal | Own schedules, own subjects grading |
| **Wali** | Portal | Child monitoring only |
| **Santri** | Portal | CBT exams only |

---

## 3. Frontend Architecture

### 3.1 Layout Components

```
resources/views/components/layouts/
├── admin.blade.php      # Admin panel layout
├── portal.blade.php     # Santri/Wali/Guru portal layout
├── landing.blade.php    # Public landing page layout
└── guest.blade.php      # Auth pages layout
```

### 3.2 Design System

| Element | Specification |
|---------|---------------|
| **Primary Color** | Green (#16a34a) |
| **Font Heading** | Outfit |
| **Font Body** | Inter |
| **Border Radius** | 8px (cards), 6px (inputs) |
| **Shadows** | shadow-sm, shadow-lg |

### 3.3 Livewire Components

#### Admin Panel
| Component | Path | Features |
|-----------|------|----------|
| Dashboard | `Admin/Dashboard.php` | Stats overview, charts |
| SantriIndex | `Admin/Santri/SantriIndex.php` | CRUD, search, pagination |
| GuruIndex | `Admin/Guru/GuruIndex.php` | CRUD, search |
| KelasIndex | `Admin/Kelas/KelasIndex.php` | CRUD with wali kelas |
| MapelIndex | `Admin/Mapel/MapelIndex.php` | CRUD, KKM |
| JadwalIndex | `Admin/Jadwal/JadwalIndex.php` | Schedule management |
| NilaiIndex | `Admin/Nilai/NilaiIndex.php` | Grade input |
| TagihanIndex | `Admin/Finance/TagihanIndex.php` | Billing management |
| ExamIndex | `Admin/Cbt/ExamIndex.php` | CBT exam management |
| ActivityLogs | `Admin/ActivityLogs.php` | System logs |

#### Portal Components
| Component | Role | Features |
|-----------|------|----------|
| `Santri/Dashboard` | Santri | CBT exam list |
| `Guru/JadwalCalendar` | Guru | Weekly schedule view |
| `Guru/NilaiInput` | Guru | Grade input for own subjects |
| `Wali/NilaiAnak` | Wali | Child grades with chart |
| `Wali/PresensiAnak` | Wali | Attendance calendar |
| `Wali/TagihanAnak` | Wali | Bills & payment status |
| `Wali/ChatWaliKelas` | Wali | Messaging with homeroom teacher |

### 3.4 PWA Configuration

```json
{
  "name": "PONSPES Pancasila Reo",
  "short_name": "PONSPES",
  "theme_color": "#16a34a",
  "display": "standalone"
}
```

**Service Worker Features:**
- Asset caching
- Offline fallback page
- Network-first strategy for API
- Cache-first for static assets

---

## 4. Backend Architecture

### 4.1 Database Schema

#### Core Tables
```
users              # Authentication
├── id, name, email, password, role
├── role: admin|operator|guru|wali|santri

santris            # Student data
├── id, nis, nama_lengkap, kelas_id, wali_id
├── tempat_lahir, tanggal_lahir, alamat, foto

gurus              # Teacher data
├── id, user_id, nip, nama_lengkap
├── mata_pelajaran, telepon

kelas              # Classes
├── id, nama_kelas, tingkat, wali_kelas_id

mapels             # Subjects
├── id, kode, nama, kkm

jadwals            # Schedules
├── id, kelas_id, mapel_id, guru_id
├── hari, jam_mulai, jam_selesai

nilais             # Grades
├── id, santri_id, mapel_id
├── semester, tahun_ajaran
├── tugas, uts, uas
```

#### Financial Tables
```
payment_types      # Bill types (SPP, Buku, etc)
├── id, nama, jumlah

tagihans           # Bills
├── id, santri_id, payment_type_id
├── jumlah, status, jatuh_tempo

payments           # Payments
├── id, tagihan_id, jumlah, metode
```

#### CBT Tables
```
exams              # Exam definitions
├── id, title, mapel_id, duration
├── start_time, end_time

questions          # Question bank
├── id, exam_id, question, options
├── correct_answer, points

exam_results       # Student results
├── id, exam_id, santri_id
├── answers, score, submitted_at
```

#### Support Tables
```
activity_logs      # Audit trail
├── id, user_id, action, model_type
├── description, ip_address

messages           # Chat system
├── id, santri_id, sender_id, receiver_id
├── message, is_read

ppdb_registrations # Online registration
├── id, nama, email, status
├── documents (JSON)
```

### 4.2 Models & Relationships

```php
// Key Relationships
Santri::belongsTo(Kelas::class)
Santri::belongsTo(Wali::class)
Santri::hasMany(Nilai::class)
Santri::hasMany(Tagihan::class)

Kelas::hasMany(Santri::class)
Kelas::belongsTo(Guru::class, 'wali_kelas_id')
Kelas::hasMany(Jadwal::class)

Guru::hasMany(Jadwal::class)
Guru::belongsTo(User::class)

Nilai::belongsTo(Santri::class)
Nilai::belongsTo(Mapel::class)
```

### 4.3 Controllers

| Controller | Routes | Purpose |
|------------|--------|---------|
| `SantriController` | Export/Import | Excel operations |
| `RaporController` | PDF generation | Report cards |
| `BackupController` | Backup CRUD | Database backup |
| `AnalyticsExportController` | PDF export | Analytics reports |

### 4.4 Traits

```php
// Auto-logging for models
trait LogsActivity {
    static::created() → ActivityLog::log('created', ...)
    static::updated() → ActivityLog::log('updated', ...)
    static::deleted() → ActivityLog::log('deleted', ...)
}
```

### 4.5 Mail Classes

| Mailable | Trigger | Template |
|----------|---------|----------|
| `TagihanNotification` | New bill, reminder, paid | Professional HTML |
| `NilaiNotification` | New grades available | Professional HTML |

---

## 5. API Endpoints

### 5.1 Web Routes Structure

```php
// Public Routes
Route::get('/')                    # Landing page
Route::get('/ppdb')                # PPDB form

// Auth Routes (Breeze)
Route::get('/login')
Route::post('/login')
Route::post('/logout')

// Admin Routes (admin|operator)
Route::prefix('admin')->group(...)
    /dashboard
    /santri, /guru, /kelas, /mapel
    /jadwal, /nilai, /tagihan
    /cbt/exams, /cbt/questions
    /activity-logs, /backup

// Guru Routes
Route::prefix('guru')->group(...)
    /dashboard, /jadwal, /nilai

// Wali Routes
Route::prefix('wali')->group(...)
    /dashboard, /nilai, /presensi
    /tagihan, /chat

// Santri Routes
Route::prefix('santri')->group(...)
    /dashboard, /cbt
```

---

## 6. Security

### 6.1 Authentication
- Session-based (Laravel Breeze)
- Role middleware: `role:admin,operator`
- Password hashing: bcrypt

### 6.2 Authorization
- Role-based access control
- Route middleware protection
- Blade directives: `@if(auth()->user()->role === 'admin')`

### 6.3 Data Protection
- CSRF tokens on all forms
- SQL injection prevention (Eloquent ORM)
- XSS prevention (Blade escaping)

---

## 7. Performance

### 7.1 Caching
- Service Worker (PWA)
- Browser caching for static assets
- Vite asset bundling

### 7.2 Database
- Indexed foreign keys
- Pagination (20 items/page)
- Eager loading relationships

### 7.3 Frontend
- Lazy loading images
- Livewire wire:loading states
- Debounced search inputs

---

## 8. File Structure

```
sekolah-system/
├── app/
│   ├── Http/Controllers/
│   ├── Livewire/
│   │   ├── Admin/
│   │   ├── Guru/
│   │   ├── Wali/
│   │   └── Santri/
│   ├── Models/
│   ├── Mail/
│   └── Traits/
├── resources/
│   ├── views/
│   │   ├── components/layouts/
│   │   ├── livewire/
│   │   ├── admin/
│   │   ├── guru/
│   │   ├── wali/
│   │   ├── santri/
│   │   └── emails/
│   ├── css/
│   └── js/
├── public/
│   ├── manifest.json
│   ├── sw.js
│   └── offline.html
├── database/
│   ├── migrations/
│   └── seeders/
└── routes/
    └── web.php
```

---

## 9. Environment Configuration

```env
# Required
APP_NAME=PONSPES
APP_ENV=production
APP_KEY=base64:...
APP_URL=https://ponspes.example.com

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_DATABASE=sekolah_system
DB_USERNAME=root
DB_PASSWORD=

# Email (for notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_ADDRESS=noreply@ponspes.com

# AI Features (optional)
GEMINI_API_KEY=
```

---

## 10. Deployment Checklist

- [ ] Run `composer install --optimize-autoloader --no-dev`
- [ ] Run `npm ci && npm run build`
- [ ] Run `php artisan migrate --force`
- [ ] Run `php artisan config:cache`
- [ ] Run `php artisan route:cache`
- [ ] Run `php artisan view:cache`
- [ ] Set `APP_ENV=production`
- [ ] Set `APP_DEBUG=false`
- [ ] Configure HTTPS
- [ ] Set up database backups
- [ ] Generate PWA icons

---

## 11. Future Enhancements

| Feature | Priority | Complexity |
|---------|----------|------------|
| Two-Factor Authentication | Medium | Medium |
| WhatsApp Notifications | Medium | Medium |
| Settings Page (Config UI) | Medium | Low |
| Mobile App (Flutter) | Low | High |
| Parent-Teacher Meeting Scheduler | Low | Medium |
| Library Management | Low | High |
