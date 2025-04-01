Getting Started
Clone the repository:

git clone https://github.com/AssimIsmail/api-crm-fact.git
Install PHP dependencies using Composer:

cd ./api.smc-aidsmo.org
composer install
Create a copy of the .env.example file and rename it to .env:

cp .env.example .env
Generate an application key:

php artisan key:generate
Generate JWT key:

php artisan jwt:secret
Link Storage folder:

php artisan storage:link
Configure your database in the .env file:

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=CRM-FACT
DB_USERNAME=root
DB_PASSWORD=your_database_password
Migrate and seed the database:

php artisan migrate --seed
Serve the application:

php artisan serve
