# Course and Group Management System

## Project Overview

This project is a Course and Group Management System developed as a group assignment. It allows users to efficiently manage courses, groups, and related information.

## Prerequisites

Before starting, make sure you have the following installed:
- [PHP](https://www.php.net/downloads.php) (version 7.4 or higher)
- [Composer](https://getcomposer.org/download/) (dependency manager for PHP)
- [MySQL](https://dev.mysql.com/downloads/) (database server)
- [Laragon](https://laragon.org/download/) (recommended for local development)
- Web browser (e.g., Chrome, Firefox)

## Installation Steps

1. **Navigate to the project directory**
    ```bash
    cd Proyecto-grupal-Sistema-de-Gestion-de-Cursos-y-Grupos/mini-aulas
    ```
    _This command moves you into the main folder containing the project code._

2. **Install PHP dependencies**
    ```bash
    composer install
    ```
    _Installs all required PHP libraries for the project using Composer._

3. **Set up the environment file**
    - Copy `.env.example` to `.env`:
      ```bash
      cp .env.example .env
      ```
    - Edit the `.env` file and update your database credentials and other settings.
    _The `.env` file stores sensitive configuration such as database access._

4. **Run database migrations**
    ```bash
    php artisan migrate
    ```
    _Creates all necessary tables in your database according to the migration files._

5. **(Optional) Seed the database**
    ```bash
    php artisan db:seed
    ```
    _Populates the database with initial sample data for testing or demonstration._

6. **Generate API documentation with Scramble**
    Scramble is a package that automatically generates API documentation for your Laravel project.

    - **Install Scramble:**
      ```bash
      composer require dedoc/scramble
      ```
      _Adds Scramble to your project dependencies._

    - **Publish Scramble's configuration file:**
      ```bash
      php artisan vendor:publish --provider="Dedoc\Scramble\ScrambleServiceProvider" --tag="scramble-config"
      ```
      _Creates a configuration file (`config/scramble.php`) so you can customize the API documentation._

    _After these steps, you can access the generated API documentation (usually at `/docs` or as configured in `scramble.php`)._

7. **Start the development server**
    ```bash
    php artisan serve
    ```
    _Launches a local web server so you can access the application in your browser._

8. **Access the application**
    - Open [http://localhost:8000](http://localhost:8000) in your browser.
    _This is the default address for the local development server._

## Usage

- Register or log in to manage courses and groups.
- Use the navigation menu to access different modules and features.

## Troubleshooting

- Ensure all prerequisites are installed and properly configured.
- Double-check your `.env` file for correct database settings.
- If you encounter permission issues, try running commands as an administrator.

