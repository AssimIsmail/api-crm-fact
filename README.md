# Getting Started

## Clone the Repository
```sh
git clone https://github.com/AssimIsmail/api-crm-fact.git
cd api-crm-fact
```

## Install PHP Dependencies
```sh
composer install
```

## Configure Environment Variables
Create a copy of the `.env.example` file and rename it to `.env`:
```sh
cp .env.example .env
```

## Generate Application Key
```sh
php artisan key:generate
```

## Generate JWT Secret Key
```sh
php artisan jwt:secret
```

## Link Storage Folder
```sh
php artisan storage:link
```

## Configure Database
Edit the `.env` file and update the database configuration:
```ini
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=crm_fact
DB_USERNAME=root
DB_PASSWORD=your_database_password
```

## Migrate and Seed the Database
```sh
php artisan migrate --seed
```

## Serve the Application
```sh
php artisan serve
```

