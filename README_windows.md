# Windows 10 Setup (No vendor included)

1. Create a fresh Laravel project:
   - Open PowerShell and run:
     ```powershell
     cd C:\xampp-php-8.1\htdocs
     composer create-project laravel/laravel translation_service
     ```
2. Copy files from this scaffold into the Laravel project root, merging (overwrite) the following folders/files:
   - app/
   - database/
   - routes/
   - tests/
   - composer.json (merge or replace; run `composer install` afterwards)
   - .env.example, README*.md, Dockerfile, docker-compose.yml, phpunit.xml, app/Console/Commands/*

3. Install dependencies:
   ```powershell
   cd C:\xampp-php-8.1\htdocs\translation_service
   composer install
   ```

4. Set up .env:
   ```powershell
   copy .env.example .env
   # Edit DB credentials in .env and create database translation_service in MySQL
   php artisan key:generate
   ```

5. Run migrations & seed admin:
   ```powershell
   php artisan migrate
   php artisan db:seed --class=AdminUserSeeder
   ```

6. (Optional) Seed large dataset for performance testing:
   ```powershell
   php artisan translations:seed --count=100000
   ```

7. Serve:
   ```powershell
   php artisan serve
   ```

Login with POST /api/login { "email":"admin@test.com", "password":"test123" } to get Bearer token.
