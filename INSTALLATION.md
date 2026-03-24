# ⚙️ INSTALLATION.md - Setup & Instalasi Sistem

> Panduan lengkap untuk setup, konfigurasi, dan instalasi sistem

**Versi:** 1.0.0  
**Last Updated:** 16 Maret 2026  
**OS:** macOS, Linux, Windows

---

## 📖 Daftar Isi

1. [System Requirements](#system-requirements)
2. [Development Environment Setup](#development-environment-setup)
3. [Project Installation](#project-installation)
4. [Database Setup](#database-setup)
5. [Running the Application](#running-the-application)
6. [Configuration Guide](#configuration-guide)
7. [Troubleshooting](#troubleshooting)

---

## 📋 System Requirements

### Minimum Requirements

| Component | Requirement | Tested Version |
|-----------|-------------|-----------------|
| **PHP** | 8.1+ | 8.2 |
| **MySQL** | 8.0+ | 8.0 |
| **Composer** | 2.0+ | 2.5.x |
| **Node.js** | 16+ | 18 LTS |
| **npm** | 8+ | 9.x |
| **RAM** | 2GB | 4GB+ |
| **Disk** | 1GB | 2GB+ |

### macOS Specific

- macOS 10.15+ (Catalina or newer)
- Laravel Herd (recommended for development)
- Homebrew (package manager)
- Xcode Command Line Tools

### Linux (Ubuntu/Debian)

- Ubuntu 20.04 LTS or later
- Debian 10+
- Apache2/Nginx (optional, for production)

### Windows

- Windows 10/11
- WSL2 (Windows Subsystem for Linux 2)
- or Docker Desktop

---

## 🚀 Development Environment Setup

### Option 1: Using Laravel Herd (macOS) - **RECOMMENDED**

#### 1. Install Laravel Herd

```bash
# Visit: https://herd.laravel.com
# Download and install Herd

# Verify installation
herd --version
```

#### 2. Laravel Herd provides:
- ✅ PHP 8.2
- ✅ MySQL 8.0
- ✅ Nginx
- ✅ Redis
- ✅ Node.js
- ✅ Composer

No additional setup needed! Go to: [Project Installation](#project-installation)

---

### Option 2: Manual Setup (macOS with Homebrew)

#### 1. Install Homebrew

```bash
/bin/bash -c "$(curl -fsSL https://raw.githubusercontent.com/Homebrew/install/HEAD/install.sh)"
```

#### 2. Install PHP 8.2

```bash
# Install PHP 8.2
brew install php@8.2

# Link PHP
brew link php@8.2 --force

# Verify
php --version
```

#### 3. Install MySQL 8.0

```bash
# Install MySQL
brew install mysql

# Start MySQL service
brew services start mysql

# Secure installation
mysql_secure_installation

# Verify
mysql --version
```

#### 4. Install Composer

```bash
# Download and install
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer

# Verify
composer --version
```

#### 5. Install Node.js & npm

```bash
# Using Homebrew
brew install node

# Verify
node --version
npm --version
```

---

### Option 3: Docker Setup

#### 1. Create Dockerfile

```dockerfile
FROM php:8.2-fpm

# Install dependencies
RUN apt-get update && apt-get install -y \
    mysql-client \
    libpng-dev \
    libjpeg-dev \
    git \
    curl

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

CMD ["php-fpm"]
```

#### 2. Create docker-compose.yml

```yaml
version: '3.8'

services:
  app:
    build: .
    ports:
      - "8000:8000"
    volumes:
      - .:/var/www/html
    environment:
      - DB_HOST=db
      - DB_DATABASE=task_book
      - DB_USERNAME=root
      - DB_PASSWORD=secret
    depends_on:
      - db

  db:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: secret
      MYSQL_DATABASE: task_book
    ports:
      - "3306:3306"
    volumes:
      - db_data:/var/lib/mysql

volumes:
  db_data:
```

#### 3. Run with Docker

```bash
docker-compose up -d
docker-compose exec app composer install
docker-compose exec app php artisan migrate:fresh --seed
```

---

## 📦 Project Installation

### 1. Clone/Extract Project

```bash
# Navigate to Herd projects directory (if using Herd)
cd ~/Herd

# Alternatively
cd /your/project/path
```

### 2. Install PHP Dependencies

```bash
composer install
```

**Expected output:**
```
Installing dependencies from lock file
Verifying lock file integrity... OK.
Loading composer repositories with package definitions... OK.
Installing packages...
...
✓ Installation completed
```

> Note: File `vendor/` akan dibuat (jangan push ke git)

### 3. Install JavaScript Dependencies

```bash
npm install
```

**Expected output:**
```
npm notice created a lockfile as package-lock.json
added X packages
```

### 4. Generate Environment File

```bash
# Copy example env file
cp .env.example .env

# Generate APP_KEY
php artisan key:generate
```

**Output:** `Application key set successfully.`

### 5. Configure Environment

Edit `.env` file:

```env
# App Configuration
APP_NAME="Sistem Manajemen Perpustakaan"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database Configuration
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_book
DB_USERNAME=root
DB_PASSWORD=

# Mail Configuration (optional)
MAIL_MAILER=log
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null

# Session Configuration
SESSION_DRIVER=file
CACHE_DRIVER=file
```

---

## 🗄️ Database Setup

### 1. Create Database

#### Using MySQL CLI

```bash
# Login ke MySQL
mysql -u root

# Create database
CREATE DATABASE task_book CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# Verify
SHOW DATABASES;

# Exit
EXIT;
```

#### Or using Laravel

```bash
php artisan db
# Interactive - you can run MySQL commands
```

### 2. Run Migrations

```bash
# Run all migrations
php artisan migrate

# Expected output:
# Creating table failed_jobs .....................
# Creating table users ...........................
# Creating table categories .......................
# Creating table books ............................
# Creating table borrowings .......................
```

### 3. Seed Test Data

```bash
# Run seeders
php artisan db:seed

# Expected output:
# Database seeding completed successfully!
```

### 4. Fresh Install (Reset + Migrate + Seed)

```bash
# WARNING: This will delete all data!
php artisan migrate:fresh --seed

# Confirm with 'yes' when prompted
# Do you really wish to execute this command? (yes/no) [no]: yes
```

---

### Verify Database Setup

```bash
# Check database tables
mysql -u root task_book -e "SHOW TABLES;"

# Expected output:
# Tables_in_task_book
# borrowings
# categories
# failed_jobs
# migrations
# password_resets
# users
# books
```

---

## ▶️ Running the Application

### 1. Start Development Server

```bash
# Terminal 1: Start Laravel server
php artisan serve

# Server akan running di:
# http://localhost:8000
```

### 2. Compile Frontend Assets (Optional)

```bash
# Terminal 2: Watch CSS/JS changes
npm run dev

# Or one-time compile:
npm run build
```

### 3. Access Application

Open browser:
```
http://localhost:8000
```

### 4. Login with Test Account

```
Email:    admin@library.com
Password: Admin123!
```

---

## ⚙️ Configuration Guide

### Environment Variables (.env)

#### Essential Variables

```env
# Application
APP_NAME="Sistem Manajemen Perpustakaan"
APP_ENV=local          # local, testing, production
APP_DEBUG=true         # Set to false in production
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=task_book
DB_USERNAME=root
DB_PASSWORD=

# Session
SESSION_DRIVER=file    # file, cookie, database
SESSION_LIFETIME=120   # minutes

# Cache
CACHE_DRIVER=file      # file, redis, array
```

#### Optional Variables

```env
# Mail
MAIL_MAILER=log        # log, smtp, sendmail
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=465
MAIL_USERNAME=
MAIL_PASSWORD=

# File Storage
FILESYSTEM_DISK=local  # local, s3
```

### Key Configuration Files

#### config/app.php
```php
return [
    'name' => env('APP_NAME', 'Laravel'),
    'env' => env('APP_ENV', 'production'),
    'debug' => env('APP_DEBUG', false),
    'url' => env('APP_URL', 'http://localhost'),
    'timezone' => 'Asia/Jakarta',  // Set to Indonesian timezone
    'locale' => 'en',
    'fallback_locale' => 'en',
];
```

#### config/database.php
```php
return [
    'default' => env('DB_CONNECTION', 'mysql'),
    'connections' => [
        'mysql' => [
            'driver' => 'mysql',
            'host' => env('DB_HOST', '127.0.0.1'),
            'port' => env('DB_PORT', 3306),
            'database' => env('DB_DATABASE', 'forge'),
            'username' => env('DB_USERNAME', 'root'),
            'password' => env('DB_PASSWORD', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],
    ],
];
```

---

## 🔧 Troubleshooting

### Issue 1: "Class not found" Error

**Problem:** Classes not auto-loading

**Solution:**

```bash
# Regenerate autoloader
composer dump-autoload

# Or force reload
composer dump-autoload --optimize
```

### Issue 2: "No database connection"

**Problem:** Can't connect to MySQL

**Checklist:**

```bash
# 1. Check if MySQL is running
ps aux | grep mysql

# 2. Check MySQL port
netstat -tlnp | grep 3306

# 3. Test connection
mysql -u root -p

# 4. Verify .env database settings
cat .env | grep DB_
```

### Issue 3: "SQLSTATE[HY000]: General error"

**Problem:** Database or migration error

**Solution:**

```bash
# 1. Check migrations status
php artisan migrate:status

# 2. Fresh migrate
php artisan migrate:fresh

# 3. Check logs
tail -f storage/logs/laravel.log
```

### Issue 4: "Permission denied" for storage

**Problem:** Can't write to storage directory

**Solution:**

```bash
# Set correct permissions
chmod -R 775 storage bootstrap/cache

# If using Docker
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

### Issue 5: "npm packages not found"

**Problem:** JavaScript dependencies missing

**Solution:**

```bash
# Clear and reinstall
rm -rf node_modules package-lock.json
npm install

# Or using Yarn
yarn install
```

---

## 🧪 Testing Installation

### Verify Everything Works

#### 1. Check Laravel Version
```bash
php artisan --version
# Expected: Laravel Framework 11.x.x
```

#### 2. Check Database Connection
```bash
php artisan tinker
>>> DB::connection()->getPdo()
# Should not throw error
```

#### 3. Check Models
```bash
php artisan tinker
>>> User::count()
# Should return integer >= 0
```

#### 4. Visit Application
```bash
# Open: http://localhost:8000
# Should see landing page
```

#### 5. Login Test
```
Email:    admin@library.com
Password: Admin123!
# Should see admin dashboard
```

---

## 📊 Installation Checklist

```
☐ System requirements verified
☐ PHP 8.1+ installed
☐ MySQL 8.0+ installed
☐ Composer installed
☐ Node.js installed
☐ Project files extracted
☐ composer install completed
☐ npm install completed
☐ .env file created and configured
☐ APP_KEY generated
☐ Database created
☐ Migrations run
☐ Seeders executed
☐ php artisan serve running
☐ Browser can access http://localhost:8000
☐ Can login with test account
☐ Dashboard loads correctly
☐ Can view books
☐ Can create/edit/delete books (admin)
☐ Can borrow books (member)
```

---

## 🚀 Quick Start Commands

```bash
# Complete fresh setup
git clone <repo> task_book
cd task_book
cp .env.example .env
php artisan key:generate
composer install
npm install
php artisan migrate:fresh --seed
php artisan serve

# In another terminal
npm run dev

# Open browser
open http://localhost:8000
```

---

## 📞 Next Steps After Installation

1. **Read Documentation**
   - [USER_GUIDE.md](USER_GUIDE.md) - How to use
   - [DEVELOPER_GUIDE.md](DEVELOPER_GUIDE.md) - How to develop
   - [DATABASE.md](DATABASE.md) - Database schema

2. **Run Tests**
   ```bash
   php artisan test
   ```

3. **Explore Admin Dashboard**
   - Login: admin@library.com
   - View statistics
   - Manage books

4. **Try Member Features**
   - Login as member: budi@example.com
   - Search books
   - Borrow a book

---

**Last Updated:** 16 Maret 2026  
**Next Update:** 30 April 2026
