# 🏫 PONSPES - Sistem Manajemen Pondok Pesantren

<p align="center">
  <strong>Platform Manajemen Pondok Pesantren Terintegrasi Lengkap</strong>
  <br/>
  <em>Solusi Komprehensif untuk Pengelolaan Akademik, Keuangan, dan Administratif</em>
</p>

---

## 📋 Daftar Isi

- [Tentang Proyek](#-tentang-proyek)
- [Fitur Utama](#-fitur-utama)
- [Tech Stack](#-tech-stack)
- [Persyaratan Sistem](#-persyaratan-sistem)
- [Instalasi](#-instalasi)
- [Konfigurasi](#-konfigurasi)
- [Penggunaan & Fitur Detail](#-penggunaan--fitur-detail)
- [Struktur Proyek](#-struktur-proyek)
- [API Documentation](#-api-documentation)
- [Troubleshooting](#-troubleshooting)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

---

## 🎯 Tentang Proyek

**PONSPES** adalah sistem informasi manajemen pondok pesantren yang modern dan komprehensif. Dibangun dengan teknologi terkini, sistem ini menyediakan solusi lengkap untuk:

- ✅ Manajemen data santri dan guru
- ✅ Pengelolaan akademik (jadwal, nilai, rapor)
- ✅ Sistem PPDB online (Penerimaan Peserta Didik Baru)
- ✅ Layanan billing dan pembayaran
- ✅ Portal santri, guru, dan wali
- ✅ Sistem CBT (Computer Based Testing) untuk ujian
- ✅ Manajemen absensi santri dan guru
- ✅ CMS untuk konten website
- ✅ Sistem pesan internal
- ✅ Manajemen pengumuman
- ✅ Audit trail dan activity logs

**Status**: Production Ready (~92%)  
**Versi**: 1.0  
**Last Updated**: Januari 2026

---

## ✨ Fitur Utama

### 📊 **Dashboard Admin**
- Statistik real-time (santri, guru, kelas, nilai)
- Grafik dan chart interaktif
- Monitor PPDB registrations
- Quick actions dan shortcuts
- Analytics dan reporting export

### 👥 **Manajemen Pengguna**
- Tambah/edit/hapus santri, guru, wali
- Import/export data bulk (Excel)
- Manajemen role dan permission
- Activity logs untuk audit trail
- Reset password dan account management

### 🎓 **Manajemen Akademik**
- **Santri**: CRUD dengan foto, nomor induk, data wali
- **Guru/Ustadz**: Data lengkap dengan jadwal mengajar
- **Kelas & Program**: Manajemen tingkat, kelas, dan program pembelajaran
- **Mata Pelajaran**: Database lengkap mapel dengan SKS

### 📅 **Jadwal Mengajar**
- Create/edit jadwal dengan GUI intuitif
- Tampilan calendar dan weekly view
- Filter by kelas, hari, guru
- Export ke PDF dan Excel
- Deteksi konflik jadwal otomatis

### 📝 **Manajemen Nilai & Rapor**
- Input nilai per santri/mapel (UH, UTS, UAS)
- Bulk input nilai per kelas
- Perhitungan rata-rata otomatis
- Rapor santri dengan status kelulusan
- Riwayat nilai dan tracking progress
- Export rapor ke PDF

### 🎯 **CBT (Computer Based Testing)**
- Buat dan kelola bank soal
- Design ujian dengan berbagai tipe pertanyaan
- Student attempt tracking dan submission
- Auto-grading untuk pilihan ganda
- Result analysis dan performance report

### 📋 **PPDB Online (Penerimaan Peserta Didik Baru)**
- Landing page dan informasi pendaftaran
- Form registrasi 3-step wizard
- Upload dokumentasi persyaratan
- Verifikasi dan approval workflow admin
- Konversi otomatis ke data santri
- Status tracking untuk calon santri

### 💰 **Manajemen Keuangan**
- Setup pembayaran dan biaya tahunan
- Tracking tagihan per santri
- Payment gateway integration
- Laporan pembayaran dan status tunggakan
- Invoice generation dan history

### 📱 **Portal Pengguna**

#### 🎓 **Portal Santri**
- Lihat jadwal kelas pribadi
- View nilai dan rapor
- Check pengumuman
- Akses internal messaging
- Submit PPDB form (untuk calon santri)

#### 👨‍🏫 **Portal Guru**
- Masukkan nilai santri
- Kelola jadwal mengajar
- Lihat daftar santri kelas
- Journal/catatan pembelajaran
- Attendance tracking

#### 👨‍👩‍👧 **Portal Wali**
- Monitor nilai anak
- Tracking absensi
- Lihat pengumuman penting
- Akses tagihan dan pembayaran
- Internal messaging dengan guru

### 📢 **Communication & Content**
- **Announcements**: Buat dan kelola pengumuman untuk semua pengguna
- **Internal Messaging**: Chat internal antar pengguna
- **CMS**: Kelola halaman statis website
- **Landing Page**: Content management untuk halaman depan
- **Testimonials & Banners**: Manage konten promotion

### ⚙️ **Manajemen Sistem**
- Activity logs dan audit trail lengkap
- Database backup dan restore
- Setting global sistem
- User management dengan role-based access
- Maintenance mode dan quick actions

### 📊 **Kehadiran**
- **Attendance Tracking**: Pantau kehadiran santri dan guru
- **Attendance Reports**: Generate laporan kehadiran

### 🏆 **Achievement & Rewards**
- Track prestasi santri
- Sistem achievement points
- Recognition system

---

## 🛠 Tech Stack

| Aspek | Teknologi |
|-------|-----------|
| **Framework Backend** | Laravel 12 |
| **PHP Version** | 8.2+ |
| **Frontend** | Livewire 3 + Blade + Alpine.js |
| **Styling** | Tailwind CSS |
| **Database** | MySQL 8.0 / MariaDB 10.5+ |
| **Authentication** | Laravel Breeze / Sanctum |
| **Data Export** | Maatwebsite Excel |
| **PDF Generation** | Laravel DomPDF |
| **Build Tool** | Vite + npm |
| **Package Manager** | Composer |

---

## ⚙️ Persyaratan Sistem

### **Minimum Requirements**
- PHP 8.2 atau lebih tinggi
- MySQL 8.0 atau MariaDB 10.5+
- Composer 2.0+
- Node.js 16.0+
- npm 7.0+
- Disk space minimal 500MB

### **Recommended Requirements**
- PHP 8.3+
- MySQL 8.0.37+
- SSD storage
- RAM 4GB+
- CPU 2 cores+

### **Supported Browsers**
- Chrome/Edge 90+
- Firefox 88+
- Safari 14+
- Mobile browsers (iOS Safari, Chrome Mobile)

---

## 🚀 Instalasi

### **1. Clone Repository**
```bash
git clone [repo-url] sekolah-system
cd sekolah-system
```

### **2. Install Dependencies**
```bash
# Install PHP dependencies
composer install

# Install Node dependencies
npm install
```

### **3. Setup Environment**
```bash
# Copy environment file
cp .env.example .env

# Generate application key
php artisan key:generate
```

### **4. Database Configuration**
Edit file `.env` dan konfigurasi database:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sekolah_db
DB_USERNAME=root
DB_PASSWORD=
```

### **5. Run Migrations & Seed Data**
```bash
# Create tables
php artisan migrate

# Populate dengan data dummy (optional)
php artisan db:seed

# Atau gunakan kombinasi
php artisan migrate --seed
```

### **6. Build Frontend Assets**
```bash
# Development
npm run dev

# Production
npm run build
```

### **7. Start Development Server**
```bash
# Terminal 1: Laravel server
php artisan serve

# Terminal 2: Watch for frontend changes (optional)
npm run dev

# Terminal 3: Queue worker (optional)
php artisan queue:listen

# Terminal 4: Pail logs (optional)
php artisan pail --timeout=0
```

**Atau gunakan script setup otomatis:**
```bash
composer run setup
composer run dev
```

---

## 🔧 Konfigurasi

### **Email Configuration**
Edit `.env` untuk setup email:
```env
MAIL_DRIVER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_FROM_ADDRESS=noreply@ponspes.id
MAIL_FROM_NAME="PONSPES"
```

### **Payment Gateway** (Optional)
Konfigurasi payment gateway di `.env`:
```env
PAYMENT_GATEWAY=stripe        # atau midtrans, xendit, dll
PAYMENT_KEY=your-api-key
PAYMENT_SECRET=your-secret
```

### **File Storage**
Konfigurasi storage di `.env`:
```env
FILESYSTEM_DISK=public        # atau s3, google-cloud
```

### **Queue Configuration**
Setup job queue (untuk email, export, dll):
```env
QUEUE_CONNECTION=database     # atau redis, sqs
```

---

## 📱 Penggunaan & Fitur Detail

### **Login & Akses**

1. **Admin/Operator**
   - URL: `http://localhost:8000/login`
   - Akses: `/admin/dashboard`
   - Permission: Full access

2. **Guru**
   - URL: `http://localhost:8000/login`
   - Akses: `/guru/dashboard` (jika login sebagai guru)
   - Permission: Input nilai, lihat santri, attendance

3. **Santri**
   - URL: `http://localhost:8000/login`
   - Akses: `/santri/dashboard`
   - Permission: Lihat jadwal, nilai, pengumuman

4. **Wali**
   - URL: `http://localhost:8000/login`
   - Akses: `/wali/dashboard`
   - Permission: Monitor anak, lihat nilai, messaging

### **Admin Panel - Main Menu**

```
Admin Dashboard
├── 📊 Dashboard
├── 👤 User Management
│   ├── Users
│   ├── Roles & Permissions
│   └── Activity Logs
├── 🎓 Academic
│   ├── Santri Management
│   ├── Guru Management
│   ├── Kelas & Program
│   └── Mata Pelajaran
├── 📅 Schedule
│   ├── Jadwal Mengajar
│   └── Schedule Management
├── 📝 Academic Records
│   ├── Input Nilai
│   ├── Rapor Santri
│   └── Achievement
├── 🎯 CBT Exams
│   ├── Question Bank
│   ├── Create Exam
│   └── View Attempts
├── 🎓 PPDB
│   ├── Registrations
│   └── Approval Process
├── 💰 Finance
│   ├── Billing
│   ├── Payment
│   └── Reports
├── 📢 Communication
│   ├── Announcements
│   ├── Internal Messages
│   └── Contact Lists
├── 📄 CMS
│   ├── Pages
│   ├── Banners
│   └── Testimonials
├── ⚙️ Settings
│   ├── System Settings
│   ├── Payment Config
│   └── App Settings
└── 🔒 Maintenance
    ├── Database Backup
    ├── Restore Data
    └── System Info
```

---

## 📁 Struktur Proyek

```
sekolah-system/
├── app/
│   ├── Enums/                    # Enum constants (Role, Status, dll)
│   ├── Exports/                  # Export classes untuk Excel
│   ├── Helpers/                  # Helper functions
│   ├── Http/
│   │   ├── Controllers/          # HTTP Controllers
│   │   ├── Middleware/           # Custom middleware
│   │   └── Requests/             # Request validation
│   ├── Imports/                  # Import classes untuk Excel
│   ├── Livewire/                 # Livewire components
│   │   ├── Admin/                # Admin panel components
│   │   ├── Guru/                 # Guru portal components
│   │   ├── Santri/               # Santri portal components
│   │   ├── Wali/                 # Wali portal components
│   │   └── Landing/              # Landing page components
│   ├── Mail/                     # Mailable classes untuk email
│   ├── Models/                   # Eloquent models
│   │   ├── User.php
│   │   ├── Santri.php
│   │   ├── Guru.php
│   │   ├── Kelas.php
│   │   ├── Mapel.php
│   │   ├── Nilai.php
│   │   ├── Jadwal.php
│   │   ├── Exam.php
│   │   ├── PpdbRegistration.php
│   │   ├── Message.php
│   │   ├── Announcement.php
│   │   ├── Payment.php
│   │   ├── Attendance.php
│   │   ├── ActivityLog.php
│   │   └── ... (30+ models)
│   ├── Policies/                 # Authorization policies
│   ├── Providers/                # Service providers
│   ├── Services/                 # Business logic services
│   ├── Traits/                   # Reusable traits
│   └── View/                     # View composers, view models
├── bootstrap/
│   ├── app.php
│   ├── cache/
│   └── providers.php
├── config/                       # Configuration files
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database/
│   ├── factories/                # Model factories
│   ├── migrations/               # Database migrations
│   └── seeders/                  # Database seeders
├── public/
│   ├── storage/                  # Symlink untuk storage
│   ├── build/                    # Compiled assets
│   ├── icons/                    # Icon files
│   └── img/                      # Image files
├── resources/
│   ├── css/
│   │   └── app.css              # Main stylesheet
│   ├── js/
│   │   └── app.js               # Main JavaScript
│   └── views/
│       ├── admin/               # Admin views
│       ├── guru/                # Guru portal views
│       ├── santri/              # Santri portal views
│       ├── wali/                # Wali portal views
│       ├── landing/             # Landing page views
│       ├── livewire/            # Livewire component views
│       ├── emails/              # Email templates
│       ├── layouts/             # Layout templates
│       └── components/          # Reusable components
├── routes/
│   ├── api.php                  # API routes
│   ├── auth.php                 # Authentication routes
│   ├── console.php              # Console commands
│   └── web.php                  # Web routes
├── storage/                      # File storage
│   ├── app/                     # Application files
│   ├── framework/               # Framework cache
│   └── logs/                    # Application logs
├── tests/                        # Test files
│   ├── Feature/                 # Feature tests
│   ├── Unit/                    # Unit tests
│   └── TestCase.php
├── testsprite_tests/            # Automated test scripts
├── .env.example                 # Environment template
├── artisan                       # Artisan CLI
├── composer.json                # PHP dependencies
├── package.json                 # Node dependencies
├── tailwind.config.js           # Tailwind CSS config
├── vite.config.js               # Vite build config
├── phpunit.xml                  # PHPUnit config
└── README.md                    # This file
```

---

## 🗄️ Database Models

Project memiliki 30+ models untuk mengelola:

- **User Management**: `User`, `Role`, `Permission`
- **Academic**: `Santri`, `Guru`, `Kelas`, `Program`, `Mapel`
- **Academic Records**: `Nilai`, `Jadwal`, `TeacherJournal`
- **Assessment**: `Exam`, `QuestionBank`, `ExamAttempt`, `ExamAnswer`
- **Finance**: `Payment`, `PaymentType`, `Tagihan`, `PpdbRegistration`
- **Attendance**: `Attendance`, `GuruAttendance`
- **Communication**: `Message`, `Announcement`
- **CMS**: `Page`, `LandingPageContent`, `Banner`, `Testimonial`
- **Audit Trail**: `ActivityLog`
- **Other**: `Achievement`, `PpdbDocument`, `Setting`, `SiteSetting`, `WaliRelation`

---

## 📡 API Documentation

Untuk API endpoints, lihat [routes/api.php](routes/api.php)

### **Authentication**
```bash
POST /api/login
POST /api/logout
POST /api/register
GET  /api/user
```

### **Common Endpoints**
```bash
# Santri
GET    /api/santri
POST   /api/santri
GET    /api/santri/{id}
PUT    /api/santri/{id}
DELETE /api/santri/{id}

# Guru
GET    /api/guru
GET    /api/guru/{id}

# Nilai (Grades)
GET    /api/nilai/{santriId}
POST   /api/nilai

# Similar patterns for other resources
```

---

## 🔐 Security Best Practices

- ✅ CSRF protection enabled
- ✅ SQL injection prevention (Eloquent ORM)
- ✅ XSS protection (Blade escaping)
- ✅ Password hashing (bcrypt)
- ✅ Role-based access control (RBAC)
- ✅ Policy-based authorization
- ✅ ActivityLog untuk audit trail
- ✅ Rate limiting pada API

### **Recommendations**
1. Update `.env` dengan secret keys yang kuat
2. Enable HTTPS di production
3. Setup proper database backups
4. Monitor activity logs regularly
5. Keep dependencies updated

---

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/SantriTest.php

# With coverage
php artisan test --coverage
```

Automated test scripts tersedia di [testsprite_tests/](testsprite_tests/) untuk integration testing.

---

## 📦 Maintenance

### **Database Backup**
```bash
# Create backup via admin panel
# Or via command:
php artisan backup:run

# Download dari /admin/backup
```

### **Clear Cache**
```bash
php artisan cache:clear
php artisan route:clear
php artisan config:clear
php artisan view:clear
```

### **Update Dependencies**
```bash
# PHP packages
composer update

# Node packages
npm update
npm audit fix
```

### **Deploy to Production**
Lihat [DEPLOYMENT.md](DEPLOYMENT.md) dan [PRODUCTION_CHECKLIST.md](PRODUCTION_CHECKLIST.md)

---

## 🐛 Troubleshooting

### **Error: "SQLSTATE[HY000]"**
- Check database connection di `.env`
- Ensure database exists: `mysql> CREATE DATABASE sekolah_db;`
- Run migrations: `php artisan migrate`

### **Error: "Class not found"**
- Run: `composer dump-autoload`
- Clear cache: `php artisan cache:clear`

### **Storage Permission Error**
```bash
# Fix permissions
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### **CSS/JS tidak ter-update**
```bash
# Rebuild assets
npm run build
php artisan cache:clear
```

### **Login tidak bisa**
- Pastikan user ada di database
- Check role & permissions
- Verify authentication service di `config/auth.php`

### **Export Excel Error**
- Ensure GD library installed: `php -m | grep gd`
- Check write permissions di `storage/app/`

### **Email tidak terkirim**
- Verify MAIL_* config di `.env`
- Check `storage/logs/laravel.log`
- Test dengan: `php artisan tinker` → `Mail::send(...)`

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan:
1. Fork repository
2. Create feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add AmazingFeature'`)
4. Push to branch (`git push origin feature/AmazingFeature`)
5. Open Pull Request

---

## 📄 Lisensi

Project ini dilindungi di bawah lisensi MIT. Lihat [LICENSE](LICENSE) untuk detail.

---

## 📞 Support & Contact

Untuk masalah, saran, atau pertanyaan:
- 📧 Email: support@ponspes.id
- 🐛 Issues: [GitHub Issues](issues)
- 💬 Discussions: [GitHub Discussions](discussions)

---

## 📝 Changelog

### v1.0 (Januari 2026)
- ✅ Initial release
- ✅ Core academic management
- ✅ PPDB online system
- ✅ Multi-portal (Santri, Guru, Wali)
- ✅ CBT exam system
- ✅ Financial management
- ✅ ~92% completion

---

## 🙏 Credits

- **Framework**: Laravel Community
- **Frontend**: Livewire & Tailwind Labs
- **Icons**: Heroicons & Feathericons
- **Testing**: Selenium & PHPUnit Team

---

<p align="center">
  Made with ❤️ for Indonesian Islamic Education System
  <br/>
  <strong>PONSPES v1.0</strong> — Production Ready
</p>
│   │   └── components/    # Blade components
│   └── css/               # Stylesheets
└── routes/
    └── web.php            # Web routes
```

---

## 🔐 Default Login

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@ponspes.test | password |
| Guru | guru@ponspes.test | password |
| Santri | santri@ponspes.test | password |
| Wali | wali@ponspes.test | password |

---

## 📖 Documentation

- [Deployment Guide](DEPLOYMENT.md)
- [API Routes](routes/web.php)

---

## 📄 License

This project is licensed under the MIT License.

---

<p align="center">
  Made with ❤️ for Indonesian Pondok Pesantren
</p>
