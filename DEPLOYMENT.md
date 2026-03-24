# 🚀 DEPLOYMENT.md - Panduan Deployment & Production

> Panduan lengkap untuk deployment ke production dan server management

**Versi:** 1.0.0  
**Last Updated:** 16 Maret 2026

---

## 📖 Daftar Isi

1. [Pre-Deployment Checklist](#pre-deployment-checklist)
2. [Server Setup](#server-setup)
3. [Application Deployment](#application-deployment)
4. [Database Migration](#database-migration)
5. [SSL/HTTPS Setup](#ssl-https-setup)
6. [Performance Optimization](#performance-optimization)
7. [Monitoring & Logging](#monitoring--logging)
8. [Backup & Recovery](#backup--recovery)

---

## ✅ Pre-Deployment Checklist

### Security Checks

```
☐ All secrets removed from code
☐ Database password changed from default
☐ APP_DEBUG = false in .env
☐ Session timeout configured
☐ CORS properly configured
☐ Rate limiting enabled
☐ Input validation comprehensive
☐ SQL injection prevention via ORM
☐ CSRF protection active
☐ XSS protection enabled
```

### Code Quality

```
☐ All tests passing (php artisan test)
☐ Code style consistent (./vendor/bin/pint)
☐ No console.log or debug statements
☐ No hardcoded credentials
☐ Documentation complete
☐ Dependencies updated (composer update)
☐ No deprecated functions used
☐ Error handling comprehensive
```

### Database

```
☐ Migrations tested locally
☐ Backup strategy documented
☐ Indexes optimized
☐ Foreign keys verified
☐ Data seeding plan documented
```

### Performance

```
☐ Database queries optimized
☐ Images compressed
☐ CSS/JS minified
☐ Caching strategy defined
☐ Load testing completed
```

---

## 🖥️ Server Setup

### Recommended Server Specs (Shared Hosting)

#### Minimum
```
CPU:     1-2 cores
RAM:     1-2 GB
Storage: 10 GB
PHP:     8.1+
MySQL:   5.7+
```

#### Recommended
```
CPU:     4 cores
RAM:     4-8 GB
Storage: 50-100 GB
PHP:     8.2+
MySQL:   8.0+
```

### Server Providers

Recommended hosting providers:
- **Shared Hosting:** Hostinger, Bluehost, SiteGround
- **VPS:** DigitalOcean, Linode, Vultr, AWS Lightsail
- **Cloud:** AWS, Google Cloud, Azure
- **Managed:** Heroku, Vercel (with API)

### Ubuntu Server Setup (VPS)

#### 1. Update System
```bash
sudo apt-get update
sudo apt-get upgrade -y
```

#### 2. Install PHP 8.2
```bash
sudo add-apt-repository ppa:ondrej/php
sudo apt-get update
sudo apt-get install -y php8.2-fpm php8.2-mysql php8.2-mbstring \
    php8.2-xml php8.2-bcmath php8.2-gd php8.2-curl
```

#### 3. Install MySQL 8.0
```bash
sudo apt-get install -y mysql-server

# Secure installation
sudo mysql_secure_installation

# Create database and user
sudo mysql -e "CREATE DATABASE task_book CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
sudo mysql -e "CREATE USER 'app_user'@'localhost' IDENTIFIED BY 'strong_password';"
sudo mysql -e "GRANT ALL PRIVILEGES ON task_book.* TO 'app_user'@'localhost';"
sudo mysql -e "FLUSH PRIVILEGES;"
```

#### 4. Install Nginx
```bash
sudo apt-get install -y nginx

# Start service
sudo systemctl start nginx
sudo systemctl enable nginx
```

#### 5. Install Composer
```bash
cd /tmp
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
```

---

## 📦 Application Deployment

### Method 1: Git Deploy

#### 1. Clone Repository
```bash
cd /var/www
sudo git clone https://github.com/your-repo/task_book.git
cd task_book
sudo chown -R www-data:www-data .
```

#### 2. Install Dependencies
```bash
sudo composer install --optimize-autoloader --no-dev
sudo npm install
sudo npm run build
```

#### 3. Environment Setup
```bash
sudo cp .env.example .env
sudo php artisan key:generate

# Edit .env with production values
sudo nano .env
```

**Important .env values:**
```env
APP_ENV=production
APP_DEBUG=false
DB_PASSWORD=strong_password
MAIL_MAILER=smtp
```

#### 4. Migrate Database
```bash
sudo php artisan migrate --force
sudo php artisan db:seed --force  # If needed
```

#### 5. Set Permissions
```bash
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache
sudo chmod -R 775 storage bootstrap/cache
```

### Method 2: Manual Upload (FTP)

#### 1. Upload Files
```bash
# Via FTP/SFTP:
# Upload all files except:
# - .env (configure on server)
# - vendor/ (install via composer)
# - node_modules/ (install via npm)
```

#### 2. Connect via SSH
```bash
ssh user@server.com

cd public_html/task_book

# Install dependencies
composer install --optimize-autoloader --no-dev
npm install
npm run build

# Setup environment
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate --force
```

---

## 🗄️ Database Migration

### Pre-Migration

```bash
# Backup current database (if exists)
mysqldump -u app_user -p task_book > backup_$(date +%Y%m%d).sql
```

### Run Migrations

```bash
# Test migration (in staging first)
php artisan migrate --step

# Production migration (no step, all at once)
php artisan migrate --force

# If issues, rollback
php artisan migrate:rollback --force
```

### Post-Migration

```bash
# Seed data (if applicable)
php artisan db:seed --force

# Verify migrations
php artisan migrate:status
```

---

## 🔒 SSL/HTTPS Setup

### Using Let's Encrypt (Free)

#### On Ubuntu with Nginx:

```bash
# Install Certbot
sudo apt-get install -y certbot python3-certbot-nginx

# Generate certificate
sudo certbot certonly --nginx -d perpustakaan.local -d www.perpustakaan.local

# Auto-renewal
sudo systemctl enable certbot.timer
sudo systemctl start certbot.timer
```

### Nginx Configuration

**File:** `/etc/nginx/sites-available/task_book`

```nginx
server {
    listen 443 ssl http2;
    server_name perpustakaan.local www.perpustakaan.local;

    # SSL certificates
    ssl_certificate /etc/letsencrypt/live/perpustakaan.local/fullchain.pem;
    ssl_certificate_key /etc/letsencrypt/live/perpustakaan.local/privkey.pem;

    # Security headers
    add_header Strict-Transport-Security "max-age=31536000" always;
    add_header X-Content-Type-Options "nosniff" always;
    add_header X-Frame-Options "DENY" always;
    add_header X-XSS-Protection "1; mode=block" always;

    root /var/www/task_book/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    # Deny access to hidden files
    location ~ /\. {
        deny all;
    }
}

# Redirect HTTP to HTTPS
server {
    listen 80;
    server_name perpustakaan.local www.perpustakaan.local;
    return 301 https://$server_name$request_uri;
}
```

Enable site:
```bash
sudo ln -s /etc/nginx/sites-available/task_book /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## ⚡ Performance Optimization

### 1. Caching

#### PHP OPCache
```bash
# Already included in PHP 8.2+
# Verify in php.ini:
opcache.enable=1
opcache.memory_consumption=128
opcache.interned_strings_buffer=8
opcache.max_accelerated_files=4000
```

#### Config Caching
```bash
# Cache application configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Clear caches if needed
php artisan cache:clear
php artisan config:clear
```

### 2. Database Optimization

```bash
# Optimize tables
php artisan tinker
>>> DB::statement('OPTIMIZE TABLE users, books, categories, borrowings;')
>>> exit
```

### 3. Asset Optimization

```bash
# Minify CSS/JS
npm run build

# Assets deployed to CDN (if available)
ASSET_URL=https://cdn.example.com/assets
```

### 4. Load Balancing (Optional)

```
┌───────────────────────┐
│   Load Balancer       │
│  (nginx/HAProxy)      │
└───────┬───────────────┘
        │
    ┌───┴───┬───────────┐
    ↓       ↓           ↓
┌────────┐┌────────┐┌────────┐
│ App 1  ││ App 2  ││ App 3  │
│ :8001  ││ :8002  ││ :8003  │
└────────┘└────────┘└────────┘
    │       │           │
    └───────┴───────────┘
            ↓
    ┌─────────────────┐
    │ Shared Database │
    └─────────────────┘
```

---

## 📊 Monitoring & Logging

### Log Files Location

```
storage/logs/laravel.log          # Application logs
/var/log/nginx/error.log          # Nginx errors
/var/log/php8.2-fpm.log           # PHP FPM errors
/var/log/mysql/error.log          # MySQL errors
```

### Monitoring System Health

```bash
# Check disk space
df -h

# Check memory
free -m

# Check CPU
top

# Check services status
sudo systemctl status nginx
sudo systemctl status php8.2-fpm
sudo systemctl status mysql
```

### Application Monitoring

#### New Relic (Recommended)
```bash
# Install New Relic PHP agent
sudo newrelic-install install

# Add to php.ini
extension=newrelic.so
newrelic.appname="Perpustakaan"
newrelic.license="YOUR_LICENSE_KEY"
```

#### Self-Hosted Monitoring
```bash
# Check application health
curl -X GET http://localhost:8000/health

# Monitor error log in real-time
tail -f storage/logs/laravel.log
```

---

## 💾 Backup & Recovery

### Automated Backups

#### Database Backup Script
**File:** `/home/user/backup_db.sh`

```bash
#!/bin/bash

BACKUP_DIR="/home/user/backups"
DB_NAME="task_book"
DB_USER="app_user"
TIMESTAMP=$(date +%Y%m%d_%H%M%S)

mkdir -p $BACKUP_DIR

# Backup database
mysqldump -u $DB_USER -p$DB_PASSWORD $DB_NAME | \
    gzip > $BACKUP_DIR/db_${TIMESTAMP}.sql.gz

# Keep only last 30 days
find $BACKUP_DIR -name "db_*.sql.gz" -mtime +30 -delete

echo "Database backed up: $BACKUP_DIR/db_${TIMESTAMP}.sql.gz"
```

#### Cron Job for Daily Backups
```bash
# Add to crontab
crontab -e

# Daily at 2 AM
0 2 * * * /home/user/backup_db.sh

# Listen for cron job execution
grep CRON /var/log/syslog
```

### Manual Backup

```bash
# Backup database
mysqldump -u app_user -p task_book > backup.sql

# Backup application files
tar -czf task_book_backup.tar.gz /var/www/task_book

# Store in safe location
scp backup.sql user@remote:/backups/
```

### Recovery

```bash
# Restore database
mysql -u app_user -p task_book < backup.sql

# Restore files
tar -xzf task_book_backup.tar.gz -C /var/www/

# Verify
php artisan migrate:status
```

---

## 🔧 Troubleshooting Production Issues

### Issue 1: Blank Page (500 Error)

```bash
# Check error log
tail -f storage/logs/laravel.log

# Check app config
php artisan config:cache --force

# Check permissions
sudo chown -R www-data:www-data storage bootstrap/cache
```

### Issue 2: Database Connection Error

```bash
# Test database connection
php artisan tinker
>>> DB::connection()->getPdo()

# Check credentials in .env
cat .env | grep DB_

# Verify MySQL running
sudo systemctl status mysql
```

### Issue 3: High Memory Usage

```bash
# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Clear caches
php artisan cache:clear
php artisan config:clear

# Optimize queries
# Review slow query log: /var/log/mysql/slow.log
```

### Issue 4: Site Not Loading

```bash
# Check Nginx config
sudo nginx -t

# View Nginx error log
tail -f /var/log/nginx/error.log

# Restart Nginx
sudo systemctl restart nginx
```

---

## 📋 Deployment Checklist

### Pre-Deployment (1 week before)

```
☐ Code review completed
☐ Tests all passing
☐ Database migrations tested
☐ Security audit done
☐ Performance testing completed
☐ SSL certificate ready
☐ Backup strategy confirmed
☐ Monitoring tools configured
☐ Team trained on procedures
```

### Deployment Day

```
☐ Create production backup
☐ Deploy code to server
☐ Install dependencies
☐ Run migrations
☐ Test critical features
☐ Monitor error logs
☐ Verify SSL working
☐ Test on production domain
☐ Update DNS (if needed)
☐ Notify team of completion
```

### Post-Deployment

```
☐ Monitor for errors (24/7)
☐ Check performance metrics
☐ Verify all features working
☐ User acceptance testing
☐ Document any changes
☐ Schedule post-deployment review
☐ Set up automated monitoring
```

---

## 🔄 Continuous Deployment (Optional)

### GitHub Actions Auto-Deploy

```yaml
name: Deploy to Production

on:
  push:
    branches: [main]

jobs:
  deploy:
    runs-on: ubuntu-latest
    
    steps:
      - uses: actions/checkout@v2
      
      - name: Deploy via SSH
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.HOST }}
          username: ${{ secrets.USERNAME }}
          key: ${{ secrets.SSH_KEY }}
          script: |
            cd /var/www/task_book
            git pull origin main
            composer install --optimize-autoloader --no-dev
            npm install && npm run build
            php artisan migrate --force
            php artisan cache:clear
```

---

**Last Updated:** 16 Maret 2026  
**Next Update:** 30 April 2026
