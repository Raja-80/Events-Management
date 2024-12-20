# EventS Management Project

## Setup Guide



### Step 1: Configure your Database
Make sure to configure your database in the .env file (DB_CONNECTION, DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).


### Step 2: Install PHP dependencies

composer install


### Step 3: Install JavaScript dependencies

npm install


### Step 4: Run migrations and seed the database

php artisan migrate


### Optional: Seed the database with sample data

php artisan db:seed


### Step 5: Run the project & Starting the Laravel development server...

npm run watch

### Then run

php artisan serve


The project should be running at http://127.0.0.1:8000