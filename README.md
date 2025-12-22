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
   # for mysql
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=postgres
   DB_PASSWORD=postgres
   ```

   ```env
   # for postgresql
   DB_CONNECTION=pgsql
   DB_HOST=127.0.0.1
   DB_PORT=5432
   DB_DATABASE=your_database_name
   DB_USERNAME=postgres
   DB_PASSWORD=postgres
   ```

6. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

7. **Create a test user** (optional but recommended for testing):

   You can create a user using PHP Tinker:

   ```bash
   php artisan tinker
   ```

   Then run the following command in the Tinker console:

   ```php
   User::create([
       'name' => 'Test User',
       'email' => 'test@example.com',
       'password' => Hash::make('password')
   ]);
   ```

   Or create a user in a single command:

   ```bash
   php artisan tinker --execute="User::create(['name' => 'Test User', 'email' => 'test@example.com', 'password' => Hash::make('password')]);"
   ```

   Exit Tinker by typing `exit` or pressing `Ctrl+D`.

8. **Install Node.js dependencies**:
   ```bash
   npm install
   ```

9. **Build frontend assets** (for production):
   ```bash
   npm run build
   ```

## Laravel Sanctum Setup

This project already includes Laravel Sanctum for API authentication. The following steps document the setup process:

### 1. Install Laravel Sanctum

Run the following command;

```bash
php artisan api:install
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

### 6. API Routes

The project includes example API routes in `routes/api.php`:

- `POST /api/login` - Authenticate user and receive token
- `GET /api/me` - Get authenticated user (requires `auth:sanctum` middleware)

## Running the Project

### Development Server

Start the Laravel development server:

```bash
php artisan serve
```

The application will be available at `http://127.0.0.1:8000`.

## API Usage Examples

### Login and Get Token

```bash
curl -X POST http://localhost:8000/api/login \
  -H "Content-Type: application/json" \
  -d '{
    "email": "test@example.com",
    "password": "password"
  }'
```

Response:

```json
{
  "user": {
    "id": 1,
    "name": "Test User",
    "email": "test@example.com"
  },
  "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
}
```

### Access Protected Route

```bash
curl -X GET http://localhost:8000/api/me \
  -H "Authorization: Bearer YOUR_TOKEN_HERE"
```

## Testing the API with Bruno

Bruno is a modern, open-source API client that makes it easy to test your API endpoints. Follow these steps to test the Sanctum API:

### 1. Install Bruno

Download and install Bruno from [https://www.usebruno.com](https://www.usebruno.com) or use your preferred package manager:

```bash
# macOS (using Homebrew)
brew install --cask bruno

# Or download directly from the website if you're on Windows
```

### 2. Create a New Collection

1. Open Bruno
2. Click **"New Collection"** or **"Create Collection"**
3. Name it "Laravel Sanctum API" (or any name you prefer)
4. Set the base URL to: `http://127.0.0.1:8000/api`

### 3. Create Environment Variables (Optional but Recommended)

1. In your Bruno collection, go to **Environments**
2. Create a new environment (e.g., "Local")
3. Add the following variables:
   - `base_url`: `http://127.0.0.1:8000/api`
   - `token`: (leave empty, will be set after login)

### 4. Test the Login Endpoint

1. Create a new request in your collection
2. Name it "Login"
3. Set the method to **POST**
4. Set the URL to: `{{base_url}}/login` (or `http://127.0.0.1:8000/api/login`)
5. Go to the **Body** tab and select **JSON**
6. Add the following JSON body (using the test user created in step 7 of setup):

   ```json
   {
     "email": "test@example.com",
     "password": "password"
   }
   ```

7. Click **Send**
8. You should receive a response with the user data and token:

   ```json
   {
     "user": {
       "id": 1,
       "name": "Test User",
       "email": "test@example.com"
     },
     "token": "1|xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx"
   }
   ```

9. **Save the token**: Copy the token from the response. You'll need it for authenticated requests.

### 5. Test the Protected Route (/me)

1. Create a new request in your collection
2. Name it "Get Current User"
3. Set the method to **GET**
4. Set the URL to: `{{base_url}}/me` (or `http://127.0.0.1:8000/api/me`)
5. Go to the **Headers** tab
6. Add a new header:
   - **Key**: `Authorization`
   - **Value**: `Bearer YOUR_TOKEN_HERE` (replace `YOUR_TOKEN_HERE` with the token from the login response)

   Alternatively, if you set up environment variables, you can use:
   - **Key**: `Authorization`
   - **Value**: `Bearer {{token}}`

7. Click **Send**
8. You should receive the authenticated user's data:

   ```json
   {
     "data": {
       "id": 1,
       "name": "Test User",
       "email": "test@example.com"
     }
   }
   ```
