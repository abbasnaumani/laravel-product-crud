# Product CRUD (Laravel 10 + PHP 8.1 + MySQL 8)
Product CRUD built with Laravel 10 + PHP 8.1 and MySQL 8.


### Requirements

- PHP 8.1 or higher (bcmath bz2 intl mbstring opcache pdo_mysql pcntl redis sockets xsl zip)
- MySQL 8.0.12 or higher

### Installation

1. Clone the repo, and if you have docker then skip all points and see 6th point.
   ```sh
   git clone https://github.com/abbasnaumani/laravel-product-crud.git
   ```
2. setup .env file and database, there is .env.example file copy file and create .env file if not exist
   1. Make sure .env file is exist
   2. create db and update .env file like following instructions, choose password if required
    ```text
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=laraveld_db
     DB_USERNAME=root
     DB_PASSWORD=
   ```

3. Install Composer packages
   ```sh
   composer install
   php artisan migrate --seed
   php artisan storage:link
   ```
4. Laravel Artisan commands to populate seeders data and linking image with public path 
   ```sh
   php artisan migrate --seed
   php artisan storage:link
   ```
5. Install NPM packages & create build
   ```sh
   npm install
   npm run build
   ```

6. Docker configurations:
   ```sh
    docker compose up
    docker compose run --rm composer install
    docker compose run --rm appserver php artisan migrate --seed
    docker compose run --rm appserver php artisan storage:link
    docker compose run --rm npm npm install
    docker compose run --rm npm npm run build
   ```
