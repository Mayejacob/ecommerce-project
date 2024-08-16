# E-Commerce Platform

This project is a fully-featured e-commerce platform built with Laravel, following the repository pattern to ensure separation of concerns, code reusability, and testability.

## Table of Contents
- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Usage](#usage)
- [Testing](#testing)
- [Contributing](#contributing)
- [License](#license)

## Features
- **Product Management**: Create, update, and manage products.
- **Category Management**: Organize products into categories.
- **User Authentication**: User registration, login, and password recovery.
- **Shopping Cart**: Add, update, and remove products in the cart.
- **Order Management**: Place orders and track their status.
- **Payment Integration**: Integration with popular payment gateways.
- **Admin Dashboard**: Manage users, products, categories, and orders.
- **Search and Filtering**: Full-text search and filtering by categories, price, etc.
- **Multi-language Support**: Supports multiple languages.
- **Responsive Design**: Fully responsive for all devices.

## Installation

### Prerequisites
- PHP >= 8.1
- Composer
- MySQL or any other supported database

### Steps
1. Clone the repository:
    ```bash
    git clone https://github.com/Mayejacob/ecommerce-project.git
    cd ecommerce-platform
    ```

2. Install dependencies:
    ```bash
    composer install
    npm install
    <!-- npm run build -->
    ```

3. Copy the `.env.example` file to `.env`:
    ```bash
    cp .env.example .env
    ```

4. Generate the application key:
    ```bash
    php artisan key:generate
    ```

5. Set up your database and update the `.env` file with your database credentials:
    ```dotenv
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=
    DB_DATABASE=
    DB_USERNAME=
    DB_PASSWORD=
    ```

6. Run migrations and seed the database:
    ```bash
    php artisan migrate --seed
    ```

7. Start the development server:
    ```bash
    php artisan serve
    ```

8. Access the application at `http://localhost:8000`.

## Configuration

### Payment Gateways
- Add your payment gateway API keys in the `.env` file.

### Mail Configuration
- Configure your SMTP settings in the `.env` file to enable email notifications.

## Usage

### Repository Pattern
This project uses the repository pattern to decouple the business logic from the data access layer. Each model has a corresponding repository responsible for database operations.

**Example:**
- `ProductRepository`: Handles all database interactions related to products.
- `OrderRepository`: Manages order-related data operations.

Repositories are located in the `app/Repositories` directory. Each repository implements an interface defined in the `app/Repositories/Contracts` directory, ensuring that all data access logic is consistent and easily testable.

### Commands
- **Clear Cache**: `php artisan cache:clear`
- **Run Tests**: `php artisan test`
- **Queue Jobs**: `php artisan queue:work`

## Testing

Run the test suite with the following command:
```bash
php artisan test
```