# Translation Management Service (Laravel)

## Overview
A Laravel-based API service for managing translations across multiple locales with tagging, search, and export functionality.  
Optimized for scalability, performance (<200ms API responses), and easy integration with frontend apps like Vue.js.

## Features
- Store translations for multiple locales (`en`, `fr`, `es`, ...)
- Tag translations for context (`web`, `mobile`, `desktop`)
- Create, update, view, and search translations
- JSON export endpoint for frontend apps (always up-to-date)
- Token-based authentication
- Large dataset support (100k+ records) with streaming export
- MySQL optimization (indexes, pagination)
- Unit, feature, and performance tests included

---

## Requirements
- PHP >= 8.1
- Composer
- MySQL 8+
- XAMPP / Laravel Sail / Valet / native PHP server
- Node.js (optional for frontend integration tests)

---

## Installation

### Windows 10
```bash
# 1. Clone the repo
git clone https://github.com/abdulrehman8391/translation-service.git
cd translation-service

# 2. Install dependencies
composer install

# 3. Copy environment file
copy .env.example .env

# 4. Generate app key
php artisan key:generate

# 5. Configure .env with MySQL credentials

# 6. Migrate database
php artisan migrate

# 7. Seed admin user
php artisan db:seed --class="Database\\Seeders\\AdminUserSeeder"

# 8. (Optional) Seed large dataset
php artisan translations:seed --count=100000

# 9. Serve API
php artisan serve




==============================================
Admin Credentials
Email: admin@test.com
Password: test123

==============================================

API Documentation
All protected endpoints require Authorization: Bearer {token}.

1. Login
POST /api/login
Json:
{
  "email": "admin@test.com",
  "password": "test123"
}
Response:
{
  "token": "eyJ0eXAiOiJKV1QiLCJh..."
}


2. Create Translation
POST /api/translations
Json:
{
  "key": "app.home.title",
  "locale": "en",
  "value": "Home",
  "tags": ["web", "desktop"],
  "context": "web"
}

3. Search Translations
GET /api/translations?locale=en&tag=web&key=home

4. Export Translations
GET /api/export/en — returns latest translations for en in JSON format.


Design Choices
MySQL indexing on (key, locale) for fast lookups.

Tag search using FIND_IN_SET for flexible matching.

Streaming large exports to keep memory usage low.

Token-based authentication for API security.

Scalable schema for future locales and tags without migrations.

Unit & Feature tests to ensure performance and correctness.
