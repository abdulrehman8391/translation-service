# Linux (Ubuntu/Debian) Setup (No vendor included)

1. Create fresh Laravel project:
   ```bash
   cd ~/projects
   composer create-project laravel/laravel translation_service
   ```

2. Copy scaffold files into the Laravel project root (merge/overwrite):
   - app/ database/ routes/ tests/ composer.json .env.example README* Dockerfile docker-compose.yml phpunit.xml app/Console/Commands/*

3. Install dependencies:
   ```bash
   cd ~/projects/translation_service
   composer install
   ```

4. Setup .env and migrations:
   ```bash
   cp .env.example .env
   # edit .env DB settings and create database translation_service
   php artisan key:generate
   php artisan migrate
   php artisan db:seed --class=AdminUserSeeder
   ```

5. (Optional) Seed 100k records:
   ```bash
   php artisan translations:seed --count=100000
   ```

6. Serve:
   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```

Login with POST /api/login { "email":"admin@test.com", "password":"test123" } to get Bearer token.
