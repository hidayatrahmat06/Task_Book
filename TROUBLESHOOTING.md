# 🔧 TROUBLESHOOTING.md - Panduan Pemecahan Masalah

> Koleksi solusi untuk masalah-masalah umum dan error yang sering terjadi

**Versi:** 1.0.0  
**Last Updated:** 16 Maret 2026

---

## 📖 Daftar Isi

1. [Installation Issues](#installation-issues)
2. [Database Issues](#database-issues)
3. [Authentication Issues](#authentication-issues)
4. [Controller & Routing Issues](#controller--routing-issues)
5. [View & Frontend Issues](#view--frontend-issues)
6. [Performance Issues](#performance-issues)
7. [Deployment Issues](#deployment-issues)
8. [Browser DevTools Tips](#browser-devtools-tips)

---

## 🚀 Installation Issues

### Issue: "PHP command not found"

**Error Message:**
```
zsh: command not found: php
```

**Diagnosis:**
```bash
# Check if PHP installed
which php

# List PHP versions
brew list | grep php
```

**Solution:**

**Option A:** Install via Homebrew
```bash
brew install php@8.2
brew link php@8.2 --force

# Verify
php --version
```

**Option B:** Use Laravel Herd
```bash
# Download from https://herd.laravel.com
# Install and use built-in PHP
```

**Option C:** Add to PATH
```bash
# Edit ~/.zshrc
nano ~/.zshrc

# Add line:
export PATH="/opt/homebrew/opt/php@8.2/bin:$PATH"

# Reload shell
source ~/.zshrc
```

---

### Issue: "Composer not found"

**Error Message:**
```
zsh: command not found: composer
```

**Solution:**

```bash
# Download Composer installer
curl -sS https://getcomposer.org/installer | php

# Move to PATH
sudo mv composer.phar /usr/local/bin/composer

# Verify
composer --version
```

---

### Issue: "Composer install stuck"

**Symptoms:**
- Composer hanging during `composer install`
- No progress after 5+ minutes

**Solution:**

```bash
# Option 1: Increase timeout
composer install --no-interaction --prefer-dist --no-dev -vvv

# Option 2: Clear cache and try again
composer clearcache
composer install

# Option 3: Use different mirror
composer config repositories.packagist composer https://packagist.org
composer install

# Option 4: Check connection
ping packagist.org
```

---

### Issue: "npm install fails"

**Error Message:**
```
npm ERR! code ERESOLVE
npm ERR! ERESOLVE unable to resolve dependency tree
```

**Solution:**

```bash
# Clear cache
npm cache clean --force

# Remove node_modules
rm -rf node_modules package-lock.json

# Try legacy peer deps
npm install --legacy-peer-deps

# Or
npm install --force
```

---

## 🗄️ Database Issues

### Issue: "SQLSTATE[HY000]: General error"

**Error Message:**
```
SQLSTATE[HY000]: General error: 1030 Got error 28
```

**Diagnosis:**
```bash
# Check disk space
df -h

# Check MySQL logs
tail -f /var/log/mysql/error.log
```

**Solution:**

```bash
# Free disk space (remove old files)
sudo du -sh /*
rm -rf storage/framework/cache/*

# Restart MySQL
sudo systemctl restart mysql

# Check MySQL
php artisan tinker
>>> DB::connection()->getPdo()
```

---

### Issue: "Access denied for user"

**Error Message:**
```
SQLSTATE[HY000]: General error: 1045
Access denied for user 'root'@'localhost'
```

**Diagnosis:**
```bash
# Test MySQL connection manually
mysql -u root -p

# Check .env file
cat .env | grep DB_
```

**Solution:**

```bash
# Reset MySQL password (macOS)
mysql -u root

# In MySQL:
ALTER USER 'root'@'localhost' IDENTIFIED BY 'newpassword';
FLUSH PRIVILEGES;
EXIT;

# Update .env
DB_PASSWORD=newpassword

# Test connection
php artisan tinker
>>> DB::connection()->getPdo()
```

---

### Issue: "Database doesn't exist"

**Error Message:**
```
SQLSTATE[42000]: Syntax error or access violation: 1049 Unknown database
```

**Solution:**

```bash
# Create database
mysql -u root -p
CREATE DATABASE task_book CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
EXIT;

# Run migrations
php artisan migrate

# Seed data
php artisan db:seed
```

---

### Issue: "Migrations not running"

**Symptoms:**
- `php artisan migrate` seems to do nothing
- No new tables in database

**Solution:**

```bash
# Check migration status
php artisan migrate:status

# Force fresh migrate
php artisan migrate:fresh

# If still stuck, check migrations folder
ls -la database/migrations/

# Check if table exists
php artisan tinker
>>> Schema::hasTable('users')
```

---

### Issue: "Seeding not working"

**Error Message:**
```
Class not found exception or Model not found
```

**Solution:**

```bash
# Verify seeder file exists
cat database/seeders/DatabaseSeeder.php

# Run specific seeder
php artisan db:seed --class=UserSeeder

# With verbose
php artisan db:seed --verbose

# Fresh with seed
php artisan migrate:fresh --seed --verbose
```

---

## 🔐 Authentication Issues

### Issue: "Cannot login with correct credentials"

**Symptoms:**
- Email and password correct but login fails
- Redirects back to login page

**Diagnosis:**
```bash
# Check user exists in database
php artisan tinker
>>> User::where('email', 'admin@library.com')->first()

# Check password hash
>>> $user = User::find(1)
>>> Hash::check('Admin123!', $user->password)
```

**Solution:**

```bash
# Reset password via tinker
php artisan tinker
>>> $user = User::find(1)
>>> $user->password = Hash::make('Admin123!')
>>> $user->save()

# Or re-seed
php artisan db:seed --class=UserSeeder
```

---

### Issue: "Always redirects to login"

**Symptoms:**
- Even after login redirects to /login
- Session not persisting

**Diagnosis:**
```bash
# Check session driver
cat .env | grep SESSION_DRIVER

# Check session storage
ls -la storage/framework/sessions/
```

**Solution:**

```bash
# Option 1: Fix session directory
chmod -R 775 storage/framework/sessions

# Option 2: Use database sessions
php artisan session:table
php artisan migrate

# Update .env
SESSION_DRIVER=database

# Option 3: Clear all cookies in browser
# Settings → Clear Browsing Data → Cookies
```

---

### Issue: "CSRF token mismatch"

**Error Message:**
```
CSRF token mismatch
Session has expired or cookies disabled
```

**Diagnosis:**
```bash
# Check session file exists
ls -la storage/framework/sessions/

# Check browser cookies enabled
# In browser: DevTools → Application → Cookies
```

**Solution:**

```bash
# Clear session/cache
php artisan cache:clear
php artisan session:table
php artisan migrate

# Ensure form has @csrf token
@csrf

# Clear browser cookies and try again
```

---

## 🔌 Controller & Routing Issues

### Issue: "Class not found" error

**Error Message:**
```
Class 'App\Http\Controllers\BookController' not found
```

**Solution:**

```bash
# Regenerate autoloader
composer dump-autoload

# Check file exists and name matches
cat app/Http/Controllers/BooksController.php

# Verify namespace is correct
# Should be: namespace App\Http\Controllers;
```

---

### Issue: "Route not found (404)"

**Error Message:**
```
Route [route_name] not defined
```

**Solution:**

```bash
# Check route exists
php artisan route:list | grep books

# View all routes
php artisan route:list

# Check routes/web.php syntax
php artisan route:list --verbose

# Clear route cache
php artisan route:cache
php artisan route:clear
```

---

### Issue: "Method not allowed (405)"

**Error Message:**
```
Method POST not allowed
The POST method is not supported for route
```

**Solution:**

```bash
# Check route method matches form method
# Route: Route::post('/books', ...)
# Form: <form method="POST" action="/books">

# Common mistake: forgot to change from GET to POST
# Check routes/web.php:
Route::post('/books', [BooksController::class, 'store']);

# If using PUT/DELETE need form helper:
@method('PUT')  OR  _method=PUT
```

---

## 👁️ View & Frontend Issues

### Issue: "View not found"

**Error Message:**
```
View [books.index] not found
```

**Solution:**

```bash
# Check view file exists
ls -la resources/views/books/

# Check filename and extension
# Should be: resources/views/books/index.blade.php

# Check subdirectory structure
# View path: books.index
# File path: resources/views/books/index.blade.php
# (Replace dots with slashes)

# Clear view cache
php artisan view:cache
php artisan view:clear
```

---

### Issue: "TailwindCSS not loading"

**Symptoms:**
- Styles not applied
- Layout looks broken

**Diagnosis:**
```bash
# Check if CDN available
curl -L https://cdn.tailwindcss.com -o /dev/null -w '%{http_code}\n'
```

**Solution (Development):**

```bash
# Use Tailwind via npm
npm install -D tailwindcss

# Create config
npx tailwindcss init

# Run watcher
npm run dev

# In template, use built CSS:
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
```

**Solution (Production):**

```blade
<!-- Use CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Or link compiled file -->
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
```

---

### Issue: "Images not displaying"

**Symptoms:**
- Book cover images show broken image icon
- File upload not working

**Solution:**

```bash
# Check storage is linked
php artisan storage:link

# Check image path is correct
# File should be in: storage/app/public/covers/
# Access via: /storage/covers/image.jpg

# Fix permissions
sudo chown -R www-data:www-data storage/app/public

# Clear browser cache
Ctrl+Shift+Delete → Clear Cache
```

---

### Issue: "Form validation messages not showing"

**Symptoms:**
- Form validation occurs but no error messages displayed
- Page just reloads

**Solution:**

```blade
<!-- Add error display in form -->
@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    </div>
@endif

<!-- Or for specific field -->
@error('title')
    <span class="error">{{ $message }}</span>
@enderror
```

---

## ⚡ Performance Issues

### Issue: "Page loading slowly"

**Symptoms:**
- Page takes >2 seconds to load
- Database queries excessive

**Diagnosis:**

```bash
# Enable query logging
# In config/database.php or .env
DB_QUERY_LOG=true

# Check logs
tail -f storage/logs/laravel.log | grep "SELECT"

# Use Laravel Debugbar
composer require barryvdh/laravel-debugbar --dev
```

**Solution:**

1. **N+1 Query Problem**
```php
// ❌ BAD: Creates 1 + N queries
$books = Book::all();
foreach ($books as $book) {
    echo $book->category->name; // Extra query!
}

// ✅ GOOD: Eager loading
$books = Book::with('category')->get();
foreach ($books as $book) {
    echo $book->category->name; // No extra query
}
```

2. **Add Indexes**
```bash
php artisan tinker
>>> Schema::table('books', function ($table) {
  $table->index('title');
  $table->index('category_id');
});
```

3. **Pagination**
```php
// ❌ BAD: Load all
$books = Book::all();

// ✅ GOOD: Use pagination
$books = Book::paginate(15);
```

---

### Issue: "High memory usage"

**Symptoms:**
- `Allowed memory size ... bytes exhausted`
- Page crashes with memory error

**Solution:**

```bash
# Increase memory limit temporarily
# In .env or php.ini:
PHP_MEMORY_LIMIT=256M

# For Laravel command:
php -d memory_limit=512M artisan migrate

# Check current usage
php artisan tinker
>>> memory_get_peak_usage() / 1024 / 1024
```

---

## 🚀 Deployment Issues

### Issue: "Blank page after deployment"

**Symptoms:**
- Landing page loads but content doesn't display
- No error message

**Solution:**

```bash
# Check error logging
tail -f storage/logs/laravel.log

# Force debug mode (temporarily)
APP_DEBUG=true

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan view:clear

# Check permissions
sudo chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache
```

---

### Issue: "404 error after deployment"

**Error:** All routes return 404

**Solution:**

```bash
# Create .htaccess (if using Apache)
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews
    </IfModule>

    RewriteEngine On

    RewriteCond %{REQUEST_FILENAME} -d
    RewriteCond %{REQUEST_FILENAME} -f
    RewriteRule ^ ^ [L]

    RewriteRule ^ index.php [L]
</IfModule>
```

**Or for Nginx:** Check server block configuration
```bash
sudo nginx -t
sudo systemctl reload nginx
```

---

### Issue: "Database not accessible after deploy"

**Solution:**

```bash
# Verify .env credentials
cat .env | grep DB_

# Test connection
mysql -u app_user -p -h db_host task_book

# If connection string is wrong:
php artisan migrate --database=mysql

# Reset and migrate
php artisan migrate:fresh --force
```

---

### Issue: "Composer dependencies outdated"

**Solution:**

```bash
# Check outdated packages
composer outdated

# Update safely
composer update --no-dev

# Update specific package
composer update laravel/framework

# Lock to specific version
composer require laravel/framework:^11.0
```

---

## 🎮 Browser DevTools Tips

### Chrome DevTools Debugging

#### Network Tab
```
1. Open DevTools: F12
2. Go to Network tab
3. Reload page
4. Look for:
   - Failed requests (red)
   - Slow requests (yellow)
   - Error status codes (4xx, 5xx)
```

#### Console Tab
```
1. Open DevTools: F12
2. Go to Console tab
3. Check for JavaScript errors (red)
4. Check for warnings (yellow)
5. Type commands directly
```

#### Application Tab (Storage)
```
1. DevTools → Application
2. Check Session/Cookies
3. Look for XSRF token
4. Check localStorage/SessionStorage
```

#### Performance Tab
```
1. DevTools → Performance
2. Click Record
3. Reload page
4. Stop Recording
5. Analyze:
   - Page Load time
   - Rendering time
   - Script execution
```

---

## 📞 Getting Help

### Debug Information to Collect

```
When reporting issues, provide:

1. Error message (full text)
2. Stack trace (if available)
3. .env file (sanitized)
4. Recent log entries (storage/logs/laravel.log)
5. Laravel version: php artisan --version
6. PHP version: php --version
7. Browser and version
8. Steps to reproduce
9. Expected vs actual behavior
```

### Useful Debug Commands

```bash
# System information
php -v
composer --version
npm --version
mysql --version

# Laravel information
php artisan about
php artisan env
php artisan config:show

# Database check
php artisan db
# Then: SELECT 1;

# Test routes
php artisan route:list

# Test tinker
php artisan tinker
>>> User::count()
>>> exit
```

---

## 🔄 Common Quick Fixes

| Issue | Quick Fix |
|-------|-----------|
| Page not loading | `php artisan cache:clear && php artisan config:clear` |
| Database error | `php artisan migrate:status` then `php artisan migrate --force` |
| CSRF error | Clear browser cookies, `php artisan session:table` |
| Composer issues | `composer clearcache && composer install` |
| Slow page | Add `.with('relationships')` to queries |
| Blank page | Check `storage/logs/laravel.log` |
| Image not showing | Check file permissions and path |
| Authentication stuck | Check `.env SESSION_DRIVER` |

---

**Last Updated:** 16 Maret 2026  
**Next Update:** 30 April 2026

---

## ✅ All Issues Troubleshoot? 

If you still have issues not listed here:

1. Check application logs: `tail -f storage/logs/laravel.log`
2. Run in debug mode: `APP_DEBUG=true`
3. Use Laravel Debugbar (development only)
4. Search Laravel documentation: https://laravel.com/docs
5. Ask in Laravel Discord/Community forums
