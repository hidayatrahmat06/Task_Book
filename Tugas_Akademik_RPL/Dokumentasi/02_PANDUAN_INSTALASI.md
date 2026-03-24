# PANDUAN INSTALASI DAN SETUP
## Sistem Manajemen Tugas (Task Management System)

---

## PRASYARAT SISTEM

Sebelum menginstall aplikasi, pastikan sistem Anda memiliki:

### Software yang Diperlukan
- **PHP**: Version 8.1 atau lebih tinggi
- **MySQL**: Version 5.7 atau 8.0
- **Composer**: Version 2.0
- **Node.js**: Version 18.x atau lebih tinggi
- **Git**: Version 2.x

### Tools / IDE (Opsional)
- VS Code atau PHP IDE (PHPStorm, Sublime, dll)
- MySQL GUI (Workbench, Sequel Pro, DBeaver)
- Postman untuk API Testing

### Sistem Operasi
- Windows 10/11 atau MacOS atau Linux

---

## STEP 1: INSTALASI DEPENDENCIES

### 1.1 Install PHP 8.1+

**Windows:**
```bash
# Download dari https://www.php.net/downloads
# Atau gunakan Laragon: https://laragon.org
# Extract dan setup PATH environment
```

**MacOS (dengan Homebrew):**
```bash
brew install php@8.1
brew tap shivammathur/php
brew install shivammathur/php/php@8.1
```

**Linux (Ubuntu/Debian):**
```bash
sudo apt update
sudo apt install php8.1 php8.1-common php8.1-mysql php8.1-xml php8.1-curl
```

### 1.2 Install MySQL 8.0

**Windows:**
- Download dari https://dev.mysql.com/downloads/mysql/
- Follow installer wizard
- Setup root password

**MacOS:**
```bash
brew install mysql
brew services start mysql
mysql -u root -p  # Default password: root
```

**Linux:**
```bash
sudo apt update
sudo apt install mysql-server
sudo mysql_secure_installation
```

### 1.3 Install Composer

**Windows/MacOS/Linux:**
```bash
# Download installer dari https://getcomposer.org/download/
# Atau via command line (Linux/MacOS)

curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer --version  # Verify
```

### 1.4 Install Node.js

```bash
# Download dari https://nodejs.org/
# Atau gunakan NVM (Node Version Manager)

# Linux/MacOS dengan NVM
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
nvm install 18
nvm use 18
node --version
npm --version
```

---

## STEP 2: CLONE / CREATE PROJECT

### Option A: Clone dari Repository

```bash
git clone https://github.com/username/task-management-system.git
cd task-management-system
```

### Option B: Create Fresh Laravel Project

```bash
composer create-project laravel/laravel task-management-system
cd task-management-system
```

---

## STEP 3: SETUP ENVIRONMENT

### 3.1 Copy Environment File

```bash
cp .env.example .env
```

### 3.2 Generate Application Key

```bash
php artisan key:generate
```

### 3.3 Update File `.env`

Edit file `.env` dan update:

```env
APP_NAME="Task Management System"
APP_ENV=local
APP_KEY=base64:YOUR_KEY_AUTO_GENERATED
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_management
DB_USERNAME=root
DB_PASSWORD=yourpassword
```

### 3.4 Create Database

```bash
# Login ke MySQL
mysql -u root -p

# Di MySQL CLI
CREATE DATABASE task_management;
EXIT;
```

---

## STEP 4: INSTALL COMPOSER DEPENDENCIES

```bash
composer install
```

Proses ini akan menginstall semua PHP dependencies termasuk Laravel dan packages lainnya.

---

## STEP 5: INSTALL NPM DEPENDENCIES

```bash
npm install
```

Proses ini akan menginstall Node modules termasuk TailwindCSS.

---

## STEP 6: RUN DATABASE MIGRATIONS

```bash
php artisan migrate
```

Perintah ini akan membuat tabel `users` dan `tasks` di database.

Output yang diharapkan:
```
Migrating: 2023_01_01_000000_create_users_table
Migrated:  2023_01_01_000000_create_users_table (234.45ms)

Migrating: 2023_01_02_000000_create_tasks_table
Migrated:  2023_01_02_000000_create_tasks_table (189.33ms)
```

---

## STEP 7: (OPTIONAL) SEED DATABASE

Untuk mengisi database dengan data dummy untuk testing:

```bash
php artisan db:seed
```

---

## STEP 8: BUILD FRONTEND ASSETS

### Development Mode (dengan hot reload)

```bash
npm run dev
```

Terminal akan tetap berjalan dan menonton perubahan file CSS/JS.

### Production Mode (minified)

```bash
npm run build
```

---

## STEP 9: START DEVELOPMENT SERVER

### Terminal 1: Start Laravel Server

```bash
php artisan serve
```

Server akan run di http://localhost:8000

Output:
```
Laravel development server started: http://127.0.0.1:8000
```

### Terminal 2: Start Frontend Asset Watcher (jika belum di-build)

```bash
npm run dev
```

---

## STEP 10: VERIFY INSTALLATION

1. **Open Browser**: Buka http://localhost:8000

2. **Testing Pages:**
   - Homepage: http://localhost:8000/
   - Register: http://localhost:8000/register
   - Login: http://localhost:8000/login
   - Dashboard: http://localhost:8000/dashboard (after login)

3. **Verify Database:**

```bash
php artisan tinker

# Di Tinker shell
User::all();  # Lihat users
Task::all();  # Lihat tasks
exit
```

---

## FILESYSTEM SETUP

Jika ingin menggunakan file upload (fitur future):

```bash
php artisan storage:link
```

---

## CACHE & CONFIG SETUP

Untuk development, optional bisa jalankan:

```bash
php artisan config:cache
php artisan view:cache
```

---

## TROUBLESHOOTING

### Error: "SQLSTATE[HY000] [2002] Connection refused"

**Solusi:**
- Pastikan MySQL server sudah running
- Check DB credentials di `.env`
- Pastikan database `task_management` sudah created

```bash
# Check MySQL status
mysql -u root -p -e "SELECT 1"
```

### Error: "Class not found" atau "No such file"

**Solusi:**
```bash
composer dump-autoload
php artisan clear-all  # clear cache
```

### Error: npm packages not found

**Solusi:**
```bash
rm -rf node_modules package-lock.json
npm install
npm run dev
```

### Error: "No application encryption key has been specified"

**Solusi:**
```bash
php artisan key:generate
```

### Port 8000 sudah used

**Solusi:**
```bash
# Gunakan port lain
php artisan serve --port=8001
```

---

## COMMANDS REFERENCE

**Database:**
```bash
php artisan migrate           # Run migrations
php artisan migrate:reset     # Reset all migrations
php artisan migrate:refresh   # Reset dan run ulang
php artisan db:seed           # Seed database
```

**Cache Clearing:**
```bash
php artisan cache:clear
php artisan config:clear
php artisan view:clear
php artisan route:clear
php artisan clear-all         # Clear semua cache
```

**Tinker (Interactive Shell):**
```bash
php artisan tinker
```

**Generate Resources:**
```bash
php artisan make:model TaskModel -m  # Model + Migration
php artisan make:controller TaskController
php artisan make:migration create_tasks_table
```

---

## PRODUCTION DEPLOYMENT

Untuk deploy ke production server:

### 1. Upload Files ke Server

```bash
rsync -avz --exclude=node_modules --exclude=storage/logs . user@server:/var/www/app/
```

### 2. SSH ke Server

```bash
ssh user@server
cd /var/www/app
```

### 3. Install Dependencies

```bash
composer install --optimize-autoloader --no-dev
npm install
npm run build
```

### 4. Setup Environment

```bash
cp .env.example .env
# Edit .env untuk production settings
php artisan key:generate
php artisan migrate --force
```

### 5. Set Permissions

```bash
chmod -R 775 storage bootstrap/cache
chown -R www-data:www-data storage bootstrap/cache
```

### 6. Setup Web Server (Nginx)

```nginx
server {
    listen 80;
    server_name yourdomain.com;

    root /var/www/app/public;

    index index.php index.html index.htm;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        include snippets/fastcgi-php.conf;
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
    }
}
```

---

## FILE STRUCTURE YANG PENTING

Setelah instalasi, struktur ini harus ada:

```
project-root/
├── app/
│   ├── Http/Controllers/
│   └── Models/
├── bootstrap/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── index.php (entry point)
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
├── routes/
│   └── web.php
├── storage/
│   ├── logs/
│   └── framework/
├── tests/
├── vendor/  (created after composer install)
├── node_modules/  (created after npm install)
├── .env
├── artisan
├── composer.json
├── package.json
└── vite.config.js
```

---

## NEXT STEPS

1. **Buat User Account**: Register akun baru di http://localhost:8000/register
2. **Create First Task**: Login dan buat tugas pertama
3. **Explore Features**: Test semua fitur (CRUD, Dashboard)
4. **Read Documentation**: Lihat file `/Dokumentasi/01_LAPORAN_UTAMA.md`
5. **Test API**: Gunakan Postman untuk test endpoints

---

## SUPPORT & HELP

- **Laravel Documentation**: https://laravel.com/docs
- **TailwindCSS Documentation**: https://tailwindcss.com
- **MySQL Documentation**: https://dev.mysql.com/doc/
- **Stack Overflow**: https://stackoverflow.com/questions/tagged/laravel

---

**Setup Date**: [Tanggal Setup]  
**Last Updated**: [Tanggal Update]
