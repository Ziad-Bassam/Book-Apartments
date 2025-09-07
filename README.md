## Booking Application (Laravel 10 + Vite)

A simple apartment booking application built with Laravel 10, Blade, and Vite. Users can list apartments, request bookings, and manage payments. Admins can approve or reject apartment listings.

### Stack
- **Backend**: Laravel 10, PHP ^8.1, Eloquent ORM
- **Auth**: `laravel/ui` (classic auth scaffolding)
- **API/Auth tokens**: `laravel/sanctum` (only default `/api/user` route enabled)
- **Frontend tooling**: Vite 5, Sass, Bootstrap 5, Axios

### Requirements
- PHP 8.1+
- Composer
- Node.js 18+ (required by Vite 5)
- A MySQL-compatible database

## Getting Started

1. Install PHP dependencies:
```bash
composer install
```

2. Install JS dependencies:
```bash
npm install
```

3. Environment setup:
```bash
cp .env.example .env
php artisan key:generate
```
Configure database connection in `.env` (DB_HOST, DB_PORT, DB_DATABASE, DB_USERNAME, DB_PASSWORD).

4. Run migrations:
```bash
php artisan migrate
```

5. Run the app (two terminals):
```bash
# Terminal 1: Laravel dev server
php artisan serve

# Terminal 2: Frontend dev server (Vite)
npm run dev
```

Then open the application at the URL shown by `php artisan serve` (usually `http://127.0.0.1:8000`).

### Build for production
```bash
npm run build
```

## Application Overview

### Authentication and Roles
- Auth scaffolding via `laravel/ui` (login, register, email verification, password reset views are present).
- Admin access is enforced by middleware `App\Http\Middleware\IsAdmin` which checks `auth()->user()->role === 'admin'`.

### Core Domains
- `Apartment`: listed units with availability windows and nightly price.
- `Booking`: user requests for date ranges; statuses: `pending`, `confirmed`, `canceled`, `expired`; payment statuses: `unpaid`, `partial`, `paid`.
- `Payments`: simplistic record of payments linked to a booking.

### Database Schema (migrations)
- `apartments`
  - `user_id`, `title`, `description`, `address`, `price_per_night`, `available_from`, `available_to`, `admin_approve` (bool), `status` (`available|booked|unavailable`).
- `bookings`
  - `user_id`, `apartment_id`, `start_date`, `end_date`, `total_price`, `payment_deadline`, `paid_amount`, `status` (`pending|confirmed|canceled|expired`), `payment_status` (`unpaid|partial|paid`).
- `payments`
  - `booking_id`, `amount_paid`, `payment_date`.

### Routes

Web routes (`routes/web.php`):
- `GET /` → redirects to `apartments.index`
- Apartments (`/apartments`):
  - `GET /` index approved + available
  - `GET /all` list all approved (paginated)
  - `GET /create` create form
  - `POST /` store
  - `GET /{id}` show
  - `GET /{id}/edit` edit form
  - `PUT /{id}` update
  - `DELETE /{id}` delete
- Bookings (`/bookings`, auth required):
  - `GET /` list my bookings
  - `GET /{apartment_id}/create` create form
  - `POST /{apartment_id}` store
  - `GET /{booking}` show
  - `DELETE /{booking}` cancel (own booking)
  - `POST /{id}/confirm` owner confirms and auto-cancels conflicts
  - `POST /{id}/cancel` owner cancels
  - `POST /{id}/payment-status` owner updates payment status
- Admin Apartments (auth + admin):
  - `GET /admin/pending-apartments` pending list
  - `PATCH /admin/apartments/{apartment}/approve` approve
  - `DELETE /admin/apartments/{apartment}` reject/delete
- Payments (`/payments`, auth required):
  - `GET /unpaid` list my unpaid bookings
  - `POST /{booking_id}` mark as paid

API routes (`routes/api.php`):
- `GET /api/user` (auth:sanctum)

### Frontend
- Entrypoints: `resources/js/app.js`, `resources/sass/app.scss` (configured in `vite.config.js`).
- Uses Bootstrap 5, Axios, and Blade views under `resources/views`.

## Development Notes
- Ensure a user has `role = 'admin'` in the `users` table to access admin routes.
- The `PaymentsController` provides a minimal flow (mark booking as paid). The `payments` table exists for extension but is not currently written in that controller.
- Overlap prevention: when a booking is confirmed, other overlapping pending bookings for the same apartment are auto-canceled.

## Scripts
- `npm run dev` – start Vite dev server
- `npm run build` – build assets

## License
This project is open-sourced under the MIT license.
end
