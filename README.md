# RLQR Store

A Laravel-based web application for instant game top-ups and digital product sales.

## Features

- User registration and authentication
- Game catalog management
- Product inventory system
- Order processing and tracking
- Admin panel for content management
- Responsive design with Bootstrap
- Secure payment integration

## Requirements

- PHP 8.2 or higher
- Composer
- Node.js and npm
- MySQL or compatible database

## Installation

1. Clone the repository:
   ```bash
   git clone https://github.com/RasyidRlqr/rlqr-store.git
   cd rlqr-store
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Install Node.js dependencies:
   ```bash
   npm install
   ```

4. Copy the environment file and configure:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

5. Configure your database in `.env` file.

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

7. Seed the database (optional):
   ```bash
   php artisan db:seed
   ```

8. Build assets:
   ```bash
   npm run build
   ```

9. Start the development server:
   ```bash
   php artisan serve
   ```

## Usage

- Access the application at `http://localhost:8000`
- Register a new account or login
- Browse available games and products
- Place orders for top-ups
- Manage orders from the user dashboard
- Admin users can access `/admin` for content management

## Contributing

Contributions are welcome. Please ensure code follows Laravel standards and includes appropriate tests.

## License

This project is licensed under the MIT License.
