# cPanel Deployment Guide

This project has been prepared for deployment.

## 1. Upload
1.  Log in to your cPanel.
2.  Open **File Manager**.
3.  Navigate to the root directory (outside `public_html` is safer, e.g., `/realestate_app`). If you must verify, you can upload to `public_html`, but it is better to keep application code separate.
4.  **Upload** the `deployment.zip` file generated in your project root.
5.  **Extract** the zip file.

## 2. Setup Public Folder
1.  Move the **contents** of the extracted `public` folder to your actual public directory (e.g., `public_html` or `public_html/subdomain`).
2.  Edit `index.php` in your public directory:
    *   Find the line: `require __DIR__.'/../vendor/autoload.php';`
    *   Change it to point to your extracted app folder: `require __DIR__.'/../realestate_app/vendor/autoload.php';`
    *   Find the line: `$app = require_once __DIR__.'/../bootstrap/app.php';`
    *   Change it to: `$app = require_once __DIR__.'/../realestate_app/bootstrap/app.php';`

## 3. Environment Configuration
1.  In File Manager, find the `.env.example` file in your app folder.
2.  Copy or rename it to `.env`.
3.  Edit `.env` and set your production details:
    *   `APP_ENV=production`
    *   `APP_DEBUG=false`
    *   `APP_URL=https://your-domain.com`
    *   `DB_DATABASE=your_cpanel_db_name`
    *   `DB_USERNAME=your_cpanel_db_user`
    *   `DB_PASSWORD=your_cpanel_db_password`

## 4. Database
1.  Create a Database and User in cPanel "MySQL® Databases".
2.  Import your local database (if needed) using phpMyAdmin.
3.  If you have SSH access, run `php artisan migrate`.

## 5. Storage
1.  Ensure `storage` folder permissions are writable (775).
2.  Link the storage folder. If you have SSH:
    ```bash
    php artisan storage:link
    ```
    If not, you can create a PHP script in your public folder to run it once:
    ```php
    <?php
    symlink('/path/to/realestate_app/storage/app/public', '/path/to/public_html/storage');
    echo "Linked";
    ?>
    ```
