# google-drive
Working with google drive api

Prerequisites
-------------

- PHP >= 7.1.3
- OpenSSL PHP Extension
- PDO PHP Extension
- Mbstring PHP Extension
- Tokenizer PHP Extension
- XML PHP Extension
- Ctype PHP Extension
- JSON PHP Extension

Getting Started
---------------

#### Via Cloning The Repository:

```bash
# Get the project
git clone https://github.com/yadavaditya0/google-drive.git

# Change directory
cd google-drive

# Copy .env.example to .env
cp .env.example .env

# Generate application secure key (in .env file)
php artisan key:generate

# Create a database (with mysql or postgresql)
# And update .env file with database credentials
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_DATABASE=gdrive
# DB_USERNAME=root
# DB_PASSWORD=

# Install Composer dependencies
composer install

# Run your migrations
php artisan migrate

php artisan serve --host=localhost --port=8080
```