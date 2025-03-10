# Laravel 8 CRM Practical

## Overview

This project implements a simple CRM system in Laravel 8 with basic CRUD operations, AJAX integration, soft deletes, file uploads, and Bootstrap UI authentication.

## Features

-   **CRUD Operations** for managing contacts (Create, Read, Update, Delete)
-   **AJAX-Based Filtering & Pagination** for seamless searching and listing
-   **Custom Fields** support to store additional user-defined information
-   **File Uploads** (Profile Image & Additional Documents)
-   **Soft Deletes** to allow record recovery
-   **Bootstrap UI Authentication** for login/logout functionality

## Installation

### Prerequisites

Ensure you have the following installed on your system:

-   PHP (>=7.3)
-   Composer
-   Laravel 8
-   MySQL

### Steps to Install

1. Clone the repository:
    ```sh
    git clone https://github.com/miteshdev2802/crm-project/tree/dev
    cd crm-project
    ```
2. Install dependencies:
    ```sh
    composer install
    ```
3. Copy and configure `.env` file:

    ```sh
    cp .env.example .env
    ```

    Update the following database credentials in `.env`:

    ```env
    APP_NAME="Laravel CRM"
    APP_URL=http://localhost:8000
    ASSET_URL=http://localhost:8000

    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=crm_db
    DB_USERNAME=root
    DB_PASSWORD=
    ```

4. Generate application key:
    ```sh
    php artisan key:generate
    ```
5. Run migrations and seed the database:
    ```sh
    php artisan migrate --seed
    ```
6. Create storage link for media uploads:
    ```sh
    php artisan storage:link
    ```
7. Start the development server:
    ```sh
    php artisan serve
    ```

## Routes

### Web Routes (routes/web.php)

```php
Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');
Route::get('/contacts/list', [ContactController::class, 'list'])->name('contacts.list');
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contacts.create');
Route::post('/contacts/store', [ContactController::class, 'store'])->name('contacts.store');
Route::get('/contacts/edit/{id}', [ContactController::class, 'edit'])->name('contacts.edit');
Route::post('/contacts/update/{id}', [ContactController::class, 'update'])->name('contacts.update');
Route::delete('/contacts/delete/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
```

## Usage

-   Navigate to `http://localhost:8000/contacts`
-   Use the **Filter Form** to search by name, email, phone, and custom fields
-   Click "View" to see details of a contact
-   Edit/Delete contacts using AJAX-based requests

## Authentication

Run the following command to enable authentication:

```sh
composer require laravel/ui
php artisan ui bootstrap --auth
npm install && npm run dev
```

Then migrate:

```sh
php artisan migrate
```

Login at `http://localhost:8000/login`

## License

This project is open-source and available under the MIT License.

#video link
https://www.awesomescreenshot.com/video/37387111?key=e6898f06d6040a0872c192afbc7aace6
