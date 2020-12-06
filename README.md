# Installation
After cloning this project follow the steps to run this project

## 1 - COMPOSER & NPM INSTALL 
Open the project and open a terminal/cmd and run composer install and npm install command

## 2 - CHECK DB AND CREATE DB
Open .env file and find this:

DB_DATABASE = grocerydb

Then Create a database on localhost/phpmyadmin named grocerydb (Base on the env file)

## 3 - MIGRATE TABLES
On your terminal run `php artisan migrate`

## 4 - RUN THE WEB APP
On your terminal run `php artisan serve` and open another terminal and run `npm run watch` or `npm run prod`

Then go to 127.0.0.1 on your browser to check if the web app is now working.


## NOTE
#### JWT (Jason Web Token) Tymon JWT
#### Laravel (BackEnd)
#### Rest APIs
#### Vue JS(FrontEnd)
#### MySql Database




