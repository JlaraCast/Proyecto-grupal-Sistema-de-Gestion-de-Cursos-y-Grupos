# Proyecto-grupal-Sistema-de-Gesti-n-de-Cursos-y-Grupos

## Project Overview

This project is a Course and Group Management System developed as a group assignment. It allows users to manage courses, groups, and related information efficiently.

## Prerequisites

- [PHP](https://www.php.net/downloads.php) (version 7.4 or higher)
- [Composer](https://getcomposer.org/download/)
- [MySQL](https://dev.mysql.com/downloads/)
- [Laragon](https://laragon.org/download/) (recommended for local development)
- Web browser (e.g., Chrome, Firefox)

## Installation


1. **Navigate to the project directory:**
    ```bash
    cd Proyecto-grupal-Sistema-de-Gestion-de-Cursos-y-Grupos/mini-aulas
    ```

2. **Install PHP dependencies using Composer:**
    ```bash
    composer install
    ```

3. **Set up the environment file:**
    - Copy `.env.example` to `.env` and update the database credentials as needed.


4. **Run database migrations:**
    ```bash
    php artisan migrate
    ```

5. **(Optional) Seed the database:**
    ```bash
    php artisan db:seed
    ```

6. **Start the development server:**
    ```bash
    php artisan serve
    ```

7. **HOST**
    -  [http://localhost:8000](http://localhost:8000)

## Usage

- Register or log in to manage courses and groups.
- Use the navigation menu to access different modules.

## Troubleshooting

- Ensure all prerequisites are installed and configured.
- Check your `.env` file for correct database settings.
- If you encounter permission issues, try running commands with administrator privileges.

