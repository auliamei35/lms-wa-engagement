# 🚀 LMS WA Engagement & Evaluation Automation

Sistem otomatisasi pengiriman notifikasi WhatsApp untuk meningkatkan *engagement* mahasiswa pada platform Learning Management System (LMS). Sistem ini mengintegrasikan Laravel, PostgreSQL, Redis, dan Fonnte API dengan fokus pada keamanan data (enkripsi) dan skalabilitas.

## 🛠️ Tech Stack
- **Framework:** Laravel 11
- **Database:** PostgreSQL (Data User & Task)
- **Queue Management:** Redis (Message Queuing)
- **WhatsApp Gateway:** Fonnte API
- **Styling:** Tailwind CSS (Monitoring Dashboard)

## ✨ Fitur Utama
1. **Automated Task Reminders:** Mendeteksi user yang belum mengumpulkan tugas H-1 dari deadline.
2. **Encrypted Phone Numbers:** Melindungi privasi user dengan menyimpan nomor HP dalam format terenkripsi (AES-256).
3. **Background Processing:** Menggunakan Redis Queue agar pengiriman pesan tidak membebani performa aplikasi.
4. **Monitoring Dashboard:** Halaman web untuk memantau log pengiriman pesan secara real-time.
5. **Scheduled Events:** Pengiriman otomatis untuk *Morning Huddle* dan *Friday Funday*.

## 🚀 Cara Instalasi

1. **Clone Repository**
   ```bash
   git clone (https://github.com/auliamei35/lms-wa-engagement.git)
   cd lms-wa-engagement

**Install Dependency**

composer install
npm install && npm run dev

**Konfigurasi Environment**
Salin file .env.example menjadi .env dan sesuaikan kredensial berikut:

Code snippet
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=nama_db_kamu

QUEUE_CONNECTION=redis

FONNTE_TOKEN=your_token_here

**Generate Key & Migrasi Database**

php artisan key:generate
php artisan migrate

**Menjalankan Aplikasi**
Untuk menjalankan sistem secara penuh, buka 3 terminal terpisah:

Terminal 1: Web Server

php artisan serve
Akses dashboard di: http://localhost:8000/dashboard

Terminal 2: Queue Worker (Pemroses Antrean)

php artisan queue:work

Terminal 3: Task Scheduler (Penjadwal Otomatis)

php artisan schedule:work

# Pengujian Manual (Tinker)
Gunakan Laravel Tinker untuk memicu pengiriman pesan secara instan:

php artisan tinker

# Kirim Reminder Tugas
(new App\Services\ReminderService)->sendTaskReminders();

# Kirim Reminder Event
(new App\Services\ReminderService)->sendEventReminder('huddle');

Karena saya menggunakan **Redis**, pastikan aplikasi Redis di laptop (atau lewat Docker/Brew) selalu menyala saat kamu menjalankan `queue:work`. Jika tidak, pesan akan tertahan dan tidak terkirim.