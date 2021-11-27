# SagerDrone Backend

## Installation

Clone the repository

    git clone git@github.com:yazansalhi/SagerDrone-backend.git

Switch to the repo folder

    cd SagerDrone

Install all the dependencies using composer

    composer install

Copy the example env file and make the required configuration changes in the .env file

    cp .env.example .env

Generate a new application key

    php artisan key:generate


Run the database migrations (**Set the database connection in .env before migrating**)

    php artisan migrate

## Database seeding
Run the product seed will generate 100 user 20 category and 1000 product for testing 

    php artisan db:seed --class=ProductSeeder

***Note*** : It's recommended to have a clean database before seeding.

Start the local development server

    php artisan serve

You can now access the server at http://127.0.0.1:8001/

  
## APIs
kindly check the postman collection in the email 

Regards,
