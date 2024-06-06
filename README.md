# Pokémon Card Collection API

This is a Laravel API for managing a Pokémon card collection. The API includes endpoints for user authentication, adding, updating, deleting, viewing, and searching Pokémon cards. Each card can be filtered and sorted by various attributes and is associated with the currently logged-in user.

## Features

- User registration and authentication using Laravel Passport
- CRUD operations for Pokémon cards
- Filtering and sorting of cards based on various attributes
- Pagination support for card listings
- Protected routes ensuring only authenticated users can access card data

## Requirements

- PHP >= 8.2
- Laravel >= 11.9
- PostgreSQL
- Composer
- Node.js and npm (for frontend if applicable)

## Installation

### Step 1: Clone the Repository

```sh
git clone https://github.com/diontristen/pokemon-laravel-be.git
cd pokemon-laravel-be
```

### Step 2: Install Dependencies
```sh
composer install
npm install
```

### Step 3: Environment Configuration
```sh
cp. .env.example .env
```

### Step 4: Environment Configuration
```sh
php artisan key:generate
```

### Step 5: Configure Database
```sh
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=your_database_name
DB_USERNAME=your_database_username
DB_PASSWORD=your_database_password
```

### Step 6: Run Migrations
```sh
php artisan migrate
```

### Step 7: Install Laravel passport
```sh
php artisan passport:install
```

### Step 8: Serve the application
```sh
php artisan serve
```


## Running Tests
To run the unit tests, use the following command:
```sh
php artisan test
```





