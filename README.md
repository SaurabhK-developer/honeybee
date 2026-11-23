# Honeybee Marketplace

A Laravel + MySQL + Blade marketplace for buying and selling locally. The UI uses Bootstrap 5 from its CDN; no frontend build is required.

## Features

- Browse active product and service listings with keyword, city, category, type, and price filters.
- Register, log in, and log out using the existing Laravel users table.
- Create listings with one optional image, edit or mark them sold, and delete your own listings.
- View listing details and contact a seller by email.
- Parent categories and subcategories populated by a seeder.
- Ownership checks, CSRF-protected forms, validation, password hashing, and pagination.

## Project notes

The application is a standalone marketplace. Listings and categories use the `marketplace_listings` and `marketplace_categories` tables.

## Setup

1. Install the PHP dependencies from the repository root:

   ```sh
   composer install
   ```

2. Copy `.env.example` to `.env` if needed and configure your local MySQL credentials. The app uses a separate `honeybee_marketplace` database. Existing `.env` values and database data are not removed by this cleanup.

3. Run the migrations:

   ```sh
   php artisan migrate
   ```

4. Add starter categories:

   ```sh
   php artisan db:seed --class=MarketplaceCategorySeeder
   ```

5. Enable public listing image URLs and start the application:

   ```sh
   php artisan storage:link
   php artisan serve
   ```

Open `http://127.0.0.1:8000`. Create an account, post a listing, then try the city and category filters.

## Main routes

| Route | Purpose |
| --- | --- |
| `/` | Browse/search listings |
| `/marketplace/listing/{id}` | Listing details |
| `/marketplace/register` | Create an account |
| `/marketplace/login` | Sign in |
| `/marketplace/listings/create` | Post an ad (signed in) |
| `/marketplace/my-listings` | Manage your ads (signed in) |

Category and listing schema changes are in `database/migrations`; category seed data is in `database/seeds/MarketplaceCategorySeeder.php`.
