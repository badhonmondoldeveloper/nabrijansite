# Nabrijan SaaS - cPanel Production Deployment Guide

**Target Domain**: https://nabrijan.site  
**Hosting Target**: cPanel Shared Hosting (PHP 8.2+, MySQL 8.x / MariaDB 10.3+, Apache)  
**Storage Budget**: 2GB Max Host Storage  
**Timezone**: Asia/Dhaka  
**Currency**: BDT (৳)  

---

## 1. Hosting Requirements Checklist

Before deploying, ensure your cPanel server environment meets the following specifications:

- **PHP Version**: 8.2 or 8.3 (Enabled via cPanel *Select PHP Version* or *MultiPHP Manager*)
- **PHP Extensions**: `pdo`, `pdo_mysql`, `gd` (for WebP image compression), `fileinfo`, `mbstring`, `json`
- **Database Server**: MySQL 8.0+ or MariaDB 10.3+ (InnoDB Engine, `utf8mb4` charset)
- **Web Server**: Apache with `mod_rewrite` and `mod_headers` enabled
- **SSL Certificate**: AutoSSL / Let's Encrypt Wildcard SSL Certificate

---

## 2. Step-by-Step Deployment Procedure

### Step 1: Upload Project Files to cPanel
1. Compress the entire project directory into a `.zip` archive.
2. Log in to your cPanel account and open **File Manager**.
3. Navigate to the root directory (or `public_html` for primary domain).
4. Upload `nabrijan.zip` and extract its contents into your target root folder (e.g., `/home/username/nabrijan`).

### Step 2: Web Root & DocumentRoot Configuration
1. In cPanel **Domains** or **Subdomains**, set the Document Root for `nabrijan.site` to point to the `public` subfolder:
   `Document Root: /home/username/nabrijan/public`
2. Verify that `.htaccess` files exist in both the root folder and the `public` folder:
   - Root `.htaccess` redirects all requests to `public/index.php`.
   - `public/.htaccess` handles front-controller rewriting and security headers (`X-Content-Type-Options`, `X-Frame-Options`, `X-XSS-Protection`).

### Step 3: MySQL Database Setup & Data Import
1. In cPanel, navigate to **MySQL Databases**.
2. Create a new database: `username_nabrijan_db`.
3. Create a database user: `username_nabrijan_user` with a strong password.
4. Assign the user to the database with **ALL PRIVILEGES**.
5. Open **phpMyAdmin** in cPanel:
   - Select `username_nabrijan_db`.
   - Click **Import** and select `database/schema.sql` (Creates 25 core tables).
   - Click **Import** again and select `database/seeds/seed.sql` (Seeds Super Admin user, 4 subscription plans, and 4 themes).

### Step 4: Environment Configuration (`.env`)
1. Create or edit the `.env` file in the project root directory:

```ini
APP_NAME="Nabrijan"
APP_ENV="production"
APP_DEBUG=false
APP_URL="https://nabrijan.site"
APP_DOMAIN="nabrijan.site"
TIMEZONE="Asia/Dhaka"
LOCALE="bn"

DB_HOST="127.0.0.1"
DB_PORT="3306"
DB_NAME="username_nabrijan_db"
DB_USER="username_nabrijan_user"
DB_PASS="YOUR_SECURE_DB_PASSWORD"
DB_CHARSET="utf8mb4"

SESSION_LIFETIME=7200
SESSION_SECURE=true

UPLOAD_MAX_SIZE=2097152 # 2MB Max Image Upload
MAX_STORAGE_MB=2048     # 2GB Host Storage Limit
```

### Step 5: Wildcard Subdomain Setup (`*.nabrijan.site`)
To enable dynamic merchant subdomains (e.g. `store1.nabrijan.site`):
1. In cPanel, navigate to **Subdomains**.
2. Create a wildcard subdomain:
   - Subdomain: `*`
   - Domain: `nabrijan.site`
   - Document Root: `/home/username/nabrijan/public` (Must match primary web root).
3. Ensure AutoSSL covers `*.nabrijan.site`.

### Step 6: File Permissions
Ensure proper file permissions in File Manager:
- Directories: `755`
- Files: `644`
- `storage/logs/` directory: `775` (Writable by PHP)
- `public/uploads/` directory: `775` (Writable by PHP)

---

## 3. Storage Optimization & 2GB Limit Maintenance

1. **Automatic WebP Conversion**: Product image uploads are processed through `ImageService`, converting PNG/JPEG uploads into compressed WebP format at 80% quality, reducing disk space consumption by up to 70%.
2. **File Size Caps**: File uploads are restricted to 2MB per image.
3. **Log Rotation**: System execution logs in `storage/logs/` are automatically truncated periodically.

---

## 4. Default Production Credentials

- **Super Admin Panel**: `https://nabrijan.site/login`
  - **Email**: `admin@nabrijan.site`
  - **Password**: `SuperAdmin123!` *(Change immediately after first login!)*

---

## 5. Verification Checklist

- [x] Registration works (`/register`)
- [x] Login & Logout works (`/login`, `/logout`)
- [x] Merchant Onboarding works (`/onboarding`)
- [x] Merchant Dashboard works (`/dashboard`)
- [x] Store Resolver works (`/store/{slug}`)
- [x] Product & Category CRUD works (`/dashboard/products`, `/dashboard/categories`)
- [x] WebP Image Processing works
- [x] Dynamic Theme Engine & Customizer works (`/dashboard/customize-theme`)
- [x] Cart & Server-Side Validation works (`/store/{slug}/cart`)
- [x] Transactional Order Engine & Stock Deduction works (`/store/{slug}/checkout`)
- [x] Customer Analytics & Spending Stats works (`/dashboard/customers`)
- [x] Coupon System works (`/dashboard/coupons`)
- [x] Review Moderation works (`/dashboard/reviews`)
- [x] Analytics & Notification Center works (`/dashboard/analytics`, `/dashboard/notifications`)
- [x] Subscription Plan Limits work (`/dashboard/subscription`)
- [x] Super Admin Panel works (`/admin`)
- [x] Security Hardening (CSRF, XSS, SQLi prepared statements, Tenant Isolation) verified.
