# Translation Management Service (Laravel)

## Overview
This is a Laravel-based API-driven service for managing translations across multiple locales with tagging, search, and export functionality. It is optimized for scalability, performance, and easy integration with frontend applications like Vue.js.

## Features
- Store translations for multiple locales (`en`, `fr`, `es`, ...)
- Tag translations for context (`web`, `mobile`, `desktop`)
- Create, update, view, and search translations
- JSON export endpoint for frontend apps
- Token-based authentication
- Large dataset support (100k+ records) with streaming export
- MySQL optimized with indexes and generated columns

## Requirements
- PHP >= 8.1
- Composer
- MySQL 8+
- Node.js (optional for frontend testing)
- XAMPP / Valet / Laravel Sail or equivalent

## Installation

### 1. Clone repo
```bash
git clone https://github.com/abdulrehman8391/translation-service.git
cd translation-service
