<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Project Setup

### Prerequisites

Before you begin, ensure you have the following installed on your system:

- **PHP** >= 8.2
- **Composer** (PHP dependency manager)
- **Node.js** and **npm** (for frontend assets)
- **Database** (MySQL, PostgreSQL, or SQLite)

### Installation Steps

1. **Clone the repository** (if applicable) or navigate to the project directory:
   ```bash
   cd sanctum
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Create environment file**:
   ```bash
   cp .env.example .env
   ```
   
   If `.env.example` doesn't exist, create a `.env` file manually with the following basic configuration:

   ```env
   APP_NAME=Laravel
   APP_ENV=local
   APP_KEY=
   APP_DEBUG=true
   APP_URL=http://localhost

   DB_CONNECTION=sqlite
   DB_DATABASE=database/database.sqlite
   ```

4. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

5. **Configure your database**:

   For **SQLite** (default):

   ```bash
   touch database/database.sqlite
   ```

   For **MySQL** or **PostgreSQL**, update your `.env` file:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

6. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

7. **Install Node.js dependencies**:
   ```bash
   npm install
   ```

8. **Build frontend assets** (for production):
   ```bash
   npm run build
   ```

## Laravel Sanctum Setup

This project already includes Laravel Sanctum for API authentication. The following steps document the setup process:

### 1. Install Laravel Sanctum

Sanctum is already included in `composer.json`. If you need to install it manually:

```bash
composer require laravel/sanctum
```

### 2. Publish Sanctum Configuration

The configuration file is already present at `config/sanctum.php`. If you need to publish it manually:

```bash
php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
```

### 3. Run Sanctum Migrations

The migration for `personal_access_tokens` table is already included. Run migrations:

```bash
php artisan migrate
```

This will create the `personal_access_tokens` table needed for token storage.

### 4. Configure User Model

The `User` model already includes the `HasApiTokens` trait. Verify it's present in `app/Models/User.php`:

```php
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    // ...
}
```

### 5. Configure Middleware

Sanctum middleware is already configured in `bootstrap/app.php`. The `EnsureFrontendRequestsAreStateful` middleware is applied to API routes.

### 6. Configure Stateful Domains (Optional)

If you're building a SPA (Single Page Application), configure stateful domains in `config/sanctum.php` or your `.env` file:

```env
SANCTUM_STATEFUL_DOMAINS=localhost,localhost:3000,127.0.0.1:8000
```

### 7. API Routes

The project includes example API routes in `routes/api.php`:

- `POST /api/login` - Authenticate user and receive token
- `GET /api/me` - Get authenticated user (requires `auth:sanctum` middleware)

## Running the Project

### Development Server

Start the Laravel development server:

```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

### Frontend Development (with Vite)

For frontend development with hot reloading:

```bash
npm run dev
```

This will start Vite in development mode. Access the application at `http://localhost:8000`.

### Using Composer Scripts

The project includes convenient composer scripts:

**Full setup** (install dependencies, setup env, generate key, migrate, build assets):

```bash
composer run setup
```

**Development mode** (runs server, queue, logs, and vite concurrently):

```bash
composer run dev
```

**Run tests**:

```bash
composer run test
```

## API Usage Examples

### Login and Get Token

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "user@example.com",
    "password": "password"
  }'
```

Response:

```json
{
  "user": {
    "id": 1,
    "name": "User Name",
    "email": "user@example.com"
  },
  "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
}
```

### Access Protected Route

```bash
curl -X GET http://localhost:8000/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework. You can also check out [Laravel Learn](https://laravel.com/learn), where you will be guided through building a modern Laravel application.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com)**
- **[Tighten Co.](https://tighten.co)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Redberry](https://redberry.international/laravel-development)**
- **[Active Logic](https://activelogic.com)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
