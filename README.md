# Tasteboat Backend

A modern **Laravel 12** API backend for the Tasteboat recipe-sharing application. Built with cutting-edge technologies including Inertia.js, Vue 3, Tailwind CSS, and Laravel Passport for OAuth2 authentication.

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel" alt="Laravel 12">
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=flat-square&logo=php" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/Vue-3-4FC08D?style=flat-square&logo=vue.js" alt="Vue 3">
  <img src="https://img.shields.io/badge/Tailwind-CSS-06B6D4?style=flat-square&logo=tailwind-css" alt="Tailwind CSS">
  <img src="https://img.shields.io/badge/License-MIT-green?style=flat-square" alt="MIT License">
</p>

---

## 📋 Table of Contents

- [Features](#features)
- [Tech Stack](#tech-stack)
- [Prerequisites](#prerequisites)
- [Installation](#installation)
- [Configuration](#configuration)
- [Running the Application](#running-the-application)
- [Project Structure](#project-structure)
- [API Features](#api-features)
- [Database](#database)
- [Testing](#testing)
- [Development](#development)
- [Contributing](#contributing)
- [License](#license)

---

## ✨ Features

### Core Functionality
- 🔐 **User Authentication** - OAuth2 with Laravel Passport
- 👥 **Role & Permission Management** - Fine-grained access control with Spatie
- 🍳 **Recipe Management** - Create, read, update, and manage recipes with difficulty levels and status tracking
- 🏷️ **Categories & Cuisines** - Organize recipes by category and cuisine type
- 👍 **User Interactions** - Ratings, comments, and favorites system
- 🖼️ **Image Upload & Management** - Handle recipe and user profile images with Intervention Image
- 📊 **Admin Dashboard** - Backend management interface for administrators

### Technical Highlights
- RESTful API with clean routing
- Role-based access control (RBAC)
- Database migrations and seeders for quick setup
- Comprehensive error handling
- User email verification
- Soft delete support

---

## 🛠️ Tech Stack

### Backend
- **Framework:** Laravel 12
- **PHP:** 8.2+
- **API Framework:** Inertia.js + Vue 3
- **Authentication:** Laravel Passport (OAuth2)
- **Authorization:** Spatie Laravel Permission
- **Image Processing:** Intervention Image 3.11
- **Utilities:** Ziggy for frontend route generation

### Frontend
- **Framework:** Vue 3 with Composition API
- **Styling:** Tailwind CSS 4.0
- **Components:** Reka UI + custom components
- **Table Management:** TanStack Vue Table
- **Notifications:** Vue Sonner
- **Build Tool:** Vite

### Database & Services
- **Database:** Supported by Laravel (MySQL, PostgreSQL, SQLite)
- **Queue:** Built-in Laravel queue system
- **Cache:** Multi-backend cache support
<!-- - **Testing:** PHPUnit with Mockery -->

---

## 📦 Prerequisites

Before you begin, ensure you have the following installed:

- **PHP 8.2+** - [Download](https://www.php.net/downloads)
- **Composer** - [Download](https://getcomposer.org)
- **Node.js 18+** - [Download](https://nodejs.org)
- **npm** or **yarn** - Comes with Node.js
- **Database:** MySQL 8+, PostgreSQL, or SQLite
- **Git** - [Download](https://git-scm.com)

---

## 🚀 Installation

### 1. Clone the Repository

```bash
git clone https://github.com/yourusername/tasteboat-backend.git
cd tasteboat-backend
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Install Node Dependencies

```bash
npm install
```

### 4. Create Environment File

```bash
cp .env.example .env
```

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Run Database Migrations

```bash
php artisan migrate
```

### 7. Seed the Database (Optional)

```bash
php artisan db:seed
```

---

## ⚙️ Configuration

### Environment Variables

Edit your `.env` file with the following key configurations:

```env
APP_NAME=Tasteboat
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=tasteboat
DB_USERNAME=root
DB_PASSWORD=

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@tasteboat.local

# OAuth2 (Passport)
PASSPORT_PERSONAL_ACCESS_CLIENT_ID=your_client_id
PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET=your_client_secret
```

### Database Setup

Ensure your database is created:

```bash
mysql -u root -p -e "CREATE DATABASE tasteboat;"
```

Then run migrations:

```bash
php artisan migrate --seed
```

---

## ▶️ Running the Application

### Development Mode

Start all services concurrently with a single command:

```bash
composer run dev
```

This command starts:
- Laravel Development Server (http://localhost:8000)
- Queue Listener
- Log Viewer (Pail)
- Vite Dev Server

### Individual Services

Or run services separately:

**Backend Server:**
```bash
php artisan serve
```

**Frontend Dev Server:**
```bash
npm run dev
```

<!-- **Queue Worker:**
```bash
php artisan queue:listen --tries=1
``` -->

<!-- **Logs:**
```bash
php artisan pail --timeout=0
``` -->

---

## 📁 Project Structure

```
tasteboat-backend/
├── app/
│   ├── Enums/                 # Enums (RecipeDifficulty, RecipeStatus, UserStatus)
│   ├── Http/
│   │   ├── Controllers/       # API Controllers
│   │   ├── Middleware/        # HTTP Middleware
│   │   ├── Requests/          # Form Requests & Validation
│   │   └── Resources/         # JSON Resources
│   ├── Models/
│   │   ├── User.php           # User Model
│   │   └── Backend/           # Backend Models (Recipe, Category, etc.)
│   ├── Providers/             # Service Providers
│   └── Traits/                # Reusable Traits (HasImageUpload)
├── config/                    # Configuration Files
├── database/
│   ├── factories/             # Model Factories
│   ├── migrations/            # Database Migrations
│   └── seeders/               # Database Seeders
├── resources/
│   ├── js/                    # Vue 3 Components & Pages
│   ├── css/                   # Tailwind Styles
│   └── views/                 # Blade Templates
├── routes/
│   ├── api.php                # API Routes
│   ├── backend.php            # Admin Routes
│   └── console.php            # CLI Commands
├── storage/                   # File Storage
├── tests/                     # PHPUnit Tests
└── vendor/                    # Composer Dependencies
```

---

## 🔌 API Features

### Authentication
- OAuth2 token-based authentication via Laravel Passport
- Personal access tokens for CLI and third-party clients
- Secure password reset and email verification

### Endpoints (Examples)
- `GET /api/recipes` - List all recipes
- `POST /api/recipes` - Create a new recipe
- `GET /api/recipes/{id}` - Get recipe details
- `GET /api/categories` - List all categories
- `POST /api/recipes/{id}/rate` - Rate a recipe
- `POST /api/recipes/{id}/favorite` - Add to favorites

---

## 🗄️ Database

### Core Models
- **User** - Application users with email verification and soft delete
- **Recipe** - Recipe content with difficulty levels and status tracking
- **Category** - Recipe categories
- **Cuisine** - Cuisine types
- **Rating** - User recipe ratings
- **Comment** - User comments on recipes
- **Favourite** - User favorite recipes

### Key Features
- Soft deletes for data preservation
- Timestamps (created_at, updated_at)
- Proper indexing and relationships
- Seeding support for test data

---

<!-- ## 🧪 Testing

### Run All Tests

```bash
composer run test
```

### Run Specific Test Suite

```bash
php artisan test --filter=FeatureTestName
```

### Run with Code Coverage

```bash
php artisan test --coverage
```

--- -->

## 💻 Development

### Code Quality

**Format Code with Pint:**
```bash
./vendor/bin/pint
```

**Run Linter:**
```bash
./vendor/bin/pint --test
```

### Artisan Commands

**Create a New Controller:**
```bash
php artisan make:controller RecipeController --model=Recipe
```

**Create a Migration:**
```bash
php artisan make:migration create_table_name
```

**Create a Model:**
```bash
php artisan make:model ModelName -m
```

### Database Commands

**Reset Database:**
```bash
php artisan migrate:reset
php artisan migrate --seed
```

**Fresh Installation:**
```bash
php artisan migrate:fresh --seed
```

---

## 🤝 Contributing

Contributions are welcome! Please follow these steps:

1. Fork the repository
2. Create a feature branch (`git checkout -b feature/your-feature`)
3. Commit your changes (`git commit -am 'Add new feature'`)
4. Push to the branch (`git push origin feature/your-feature`)
5. Open a Pull Request

Please ensure:
- Code follows PSR-12 standards
- All tests pass (`composer run test`)
- Code is properly formatted (`./vendor/bin/pint`)
- Meaningful commit messages are used

---

## 📝 License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

---

## 📞 Support

For issues, questions, or suggestions, please open an issue on GitHub or contact the development team.

---

**Happy Coding! 🎉**

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
