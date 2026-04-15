# AI Admin Dashboard

A simple PHP admin dashboard for managing website content and uploads.

## Overview
This project is an administration panel built with PHP, PDO, and Bootstrap. It provides a login page and a set of management pages for:

- Our Work
- Services
- Banners
- Photo Gallery
- Products
- Categories

The dashboard shows a summary of counts for these sections and allows CRUD operations on each content type.

## Project Structure

- `index.php` - Login page and authentication handler.
- `dashboard.php` - Main dashboard that shows content counts and navigation.
- `init.php` - Common bootstrap file that loads configuration, helper functions, and templates.
- `config.php` - Database connection settings for MySQL.
- `logout.php` - Ends the current session and returns to the login page.
- `include/function/functions.php` - Helper functions for page titles, redirect logic, and database counts.
- `include/template/header.php` - Shared HTML header with Bootstrap and stylesheet includes.
- `include/template/footer.php` - Shared footer and script includes.
- `design/` - Static assets folder containing CSS, JavaScript, and images.
- `upload/` - Folder for uploaded image files.
- `our_work.php`, `services.php`, `banners.php`, `photo_gallery.php`, `products.php`, `category.php` - Content management pages with CRUD actions.

## Requirements

- PHP 7.4+ or PHP 8.x
- MySQL / MariaDB
- XAMPP or another local web server environment
- `pdo_mysql` extension enabled

## Setup

1. Place the project in your web server root.
2. Create a MySQL database named `ai_3`.
3. Configure `config.php` with your database credentials.
4. Ensure the `upload/` folder is writable by the web server.
5. Open the project in your browser and log in through `index.php`.

## Notes

- The project uses PDO for database access.
- The login system currently checks the `users` table using plain credentials, so it is intended for local or development use.
- For production, consider adding password hashing, input escaping, and stronger security checks.

## Improvements Applied

- Fixed PHP error reporting setting in `init.php`.
- Improved helper function comments and default title output in `include/function/functions.php`.
- Improved redirect messaging in `include/function/functions.php`.
- Fixed the login form action to use `htmlspecialchars()` for safer output.
- Corrected the navbar HTML structure in `include/template/navbar.php`.

## Author

- Aiham Alqasem
