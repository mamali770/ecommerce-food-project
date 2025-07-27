# Laravel Online Restaurant System

This is my **second Laravel project**, built as an online restaurant platform.  
Users can **browse the menu, place orders**, and **log in as either a customer or an admin** to manage their account or the entire system.

## Features

- User & Admin Authentication
- Order Management System
- Menu Listing & Food Details
- Admin Dashboard to manage orders and food items
- Role-based access control (User / Admin)
- Clean MVC structure using Laravel 12

## Tech Stack

- PHP 8.2
- Laravel 12.x
- MySQL
- Blade Templating
- Bootstrap 5
- Git & GitHub

## How to Run Locally

```bash
git clone https://github.com/mamali770/ecommerce-food-project.git
cd online-restaurant
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
php artisan serve
