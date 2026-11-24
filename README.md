# Distribution & Fleet ERP — Laravel Web Client

![PHP](https://img.shields.io/badge/PHP-7.3%2B%20%7C%208.x-777BB4?logo=php&logoColor=white)
![Laravel](https://img.shields.io/badge/Laravel-8.x-FF2D20?logo=laravel&logoColor=white)
![jQuery](https://img.shields.io/badge/jQuery-jqGrid-0769AD?logo=jquery&logoColor=white)
![AdminLTE](https://img.shields.io/badge/UI-AdminLTE%20%2B%20Bootstrap-563D7C?logo=bootstrap&logoColor=white)
![License](https://img.shields.io/badge/license-MIT-green)

A web-based **Enterprise Resource Planning (ERP)** application for goods-distribution businesses. It covers the full **order → purchase → sales → returns → payables/receivables → settlement** cycle, inventory and cost of goods sold (COGS), and **fleet vehicle** operations, with role/ACL-based user management, reporting, and push notifications.

This project is the **web client (presentation layer)**. It talks to a **separate REST API backend** using access tokens. This application handles the UI, menu authorization, and report generation. The API handles data storage and business processing.

---

## Table of Contents

- [Key Features](#key-features)
- [Architecture](#architecture)
- [Tech Stack](#tech-stack)
- [Project Structure](#project-structure)
- [Installation](#installation)
- [Environment Configuration](#environment-configuration)
- [Module Conventions](#module-conventions)
- [Security & Authorization](#security--authorization)
- [License](#license)

---

## Key Features

### Dashboard & Operational Reminders
- Daily **work orders (SPK)** overview and SPK reminders.
- **Minimum stock** alerts.
- Fleet reminders: **service schedule, oil change, vehicle registration (STNK) expiry, insurance expiry**, and driver **license (SIM) expiry**.

### Master Data
| Module | Description |
|---|---|
| Branch, Owner, Holidays | Organization data and working calendar |
| Product, Product Group, Unit | Product catalog and units of measure |
| Customer, Customer Group, Supplier | Business partners |
| Employee, Fleet | Staff and operational vehicles |
| Bank, Payment Method, Chart of Accounts | Finance reference data |
| Parameter | Dynamic configuration (statuses, payment terms, etc.) for dropdowns |

### Sales & Purchasing Transactions
- Customer **Orders**, **Order Review** (verification and bulk editing), and **Final Orders**.
- **Purchases** and **Sales** (header–detail), with printable **invoices** and **delivery notes**.
- **Purchase Returns** and **Sales Returns**.
- **Purchase Invoices** and **Sales Invoices**.
- **Expense Transactions** and **Fleet Transactions** (vehicle operating costs).

### Finance
- **Accounts Payable** and **Accounts Receivable** ledgers.
- **Payable Settlement** and **Receivable Settlement** (header–detail).

### Inventory
- **Stock Card** per item.
- **Stock Adjustment**.
- **COGS (HPP)** and **COGS Recalculation**.

### System Administration
- Management of **Users**, **Roles**, **User Roles**, **ACL**, and **User ACL**.
- **Dynamic menu** with drag-and-drop reordering, built per user.
- **Audit Trail** (activity log) and **Error Log**.
- **Change Password** and **Reset Password** using expiring JWT tokens.

### Reporting & Export
- Print-ready reports with **Stimulsoft Reports** (`.mrt` templates).
- Data export to **Excel** (PhpSpreadsheet) and **PDF** (Dompdf).
- Most modules provide `report` and `export` endpoints.

### Notifications
- **Web Push Notifications** (VAPID) through a Service Worker (`public/sw.js`).

---

## Architecture

```
┌──────────────────────┐   HTTP + session cookie  ┌──────────────────────┐
│  Browser             │ ───────────────────────► │  Laravel Web Client  │
│  jqGrid · AdminLTE   │ ◄─────────────────────── │  (this repository)   │
│  Stimulsoft · SW     │   Blade views / JSON     │  Controllers · Blade │
└──────────────────────┘                          └──────────┬───────────┘
                                                             │ Laravel HTTP Client
                                                             │ (Bearer access_token)
                                                             ▼
                                                  ┌──────────────────────┐
                                                  │  REST API Backend    │
                                                  │  (API_URL)           │
                                                  └──────────────────────┘
```

1. **Login**: credentials are sent to the API `token` endpoint. The returned `access_token` is stored in the server-side session, and the user's menu is built and cached in the session.
2. **Authorization**: the `authorized` middleware checks the user's permission for the *class* (URI segment) and controller *method* before the request continues.
3. **Data**: controllers forward grid parameters (paging, sorting, filters) to the API and format the response for jqGrid.
4. **Reports**: API data is rendered as Stimulsoft reports, Excel files, or PDFs.

---

## Tech Stack

| Layer | Technology |
|---|---|
| Backend framework | Laravel 8, PHP 7.3+/8.x |
| API integration | Laravel HTTP Client (Guzzle), JWT, Laravel Passport & Sanctum |
| Frontend | Blade, jQuery, jqGrid, jQuery UI, EasyUI, Select2, AutoNumeric, Inputmask, Nestable2 |
| UI kit | AdminLTE, Bootstrap |
| Reporting | Stimulsoft Reports.JS, Dompdf, PhpSpreadsheet, PDF.js |
| Notifications | `laravel-notification-channels/webpush`, Service Worker |
| Build tool | Laravel Mix (webpack) |
| Testing | PHPUnit |

---

## Project Structure

```
erp/
├── app/
│   ├── Console/                # Artisan kernel
│   ├── Exceptions/             # Global exception handling
│   ├── Helpers/                # Auth & Menu helpers (globally autoloaded)
│   ├── Http/
│   │   ├── Controllers/        # 60+ ERP module controllers (master data, transactions, reports)
│   │   │   └── MyController.php    # Base controller: shared HTTP headers & utilities
│   │   ├── Middleware/         # Authorized (ACL), LoggedIn, VerifyJwtToken, NoCache, etc.
│   │   └── Requests/           # Form request validation
│   ├── Libraries/
│   │   └── Myauth.php          # Permission checks by class & method
│   ├── Models/                 # User, Role, UserRole, Menu, Aco, PasswordReset
│   ├── Notifications/          # PushNotification (web push)
│   └── Providers/              # Service providers, including MenuServiceProvider
├── bootstrap/                  # Laravel bootstrap
├── config/                     # app, auth, webpush, cors, and other configuration
├── database/
│   ├── migrations/             # users, password_resets, push_subscriptions, etc.
│   ├── factories/
│   └── seeders/
├── public/
│   ├── libraries/              # Frontend libraries (AdminLTE, jqGrid, Stimulsoft, Select2, ...)
│   ├── reports/                # Stimulsoft report templates (.mrt)
│   ├── js/enable-push.js       # Push subscription registration
│   └── sw.js                   # Service Worker for web push
├── reports/                    # Additional report templates & Stimulsoft config
├── resources/
│   └── views/                  # 50+ Blade folders, one per module
│       ├── layouts/            # master, navbar, sidebar, date-range headers
│       ├── partials/lookups/   # Reusable lookup components
│       ├── dashboard/          # Reminder & work-order widgets
│       └── <module>/           # index.blade.php, _modal.blade.php, _details.blade.php
├── routes/
│   ├── web.php                 # All module routes (auth + authorized middleware)
│   └── api.php
├── storage/
├── tests/                      # PHPUnit (Feature & Unit)
├── composer.json
├── package.json
└── webpack.mix.js
```

---

## Installation

### Requirements
- PHP 7.3+ or 8.x with the `openssl`, `mbstring`, `gd`, `zip`, and `xml` extensions
- Composer 2
- Node.js & npm
- MySQL / MariaDB (for local tables such as sessions and push subscriptions)
- A compatible REST API backend (set through `API_URL`)

### Steps

```bash
# 1. Clone the repository
git clone https://github.com/thinkabowtsya/erp-laravel.git
cd erp-laravel

# 2. Install dependencies
composer install
npm install && npm run dev

# 3. Set up the environment
cp .env.example .env
php artisan key:generate

# 4. Run local database migrations
php artisan migrate

# 5. Start the application
php artisan serve
```

Open `http://localhost:8000` and sign in with an account registered in the API backend.

---

## Environment Configuration

Key variables in `.env`:

| Variable | Purpose |
|---|---|
| `APP_URL` | Web client URL |
| `API_URL` | REST API backend base URL (must end with `/`) |
| `JWT_KEY`, `JWT_ALG` | Key and algorithm for password-reset tokens |
| `DB_*` | Local database connection |
| `VAPID_SUBJECT`, `VAPID_PUBLIC_KEY`, `VAPID_PRIVATE_KEY` | Web push notification keys |
| `PUSHER_*` | Optional, for real-time broadcasting |

Generate VAPID keys with:

```bash
php artisan webpush:vapid
```

---

## Module Conventions

Every module follows the same conventions, so new modules are quick to add:

**Routes** (`routes/web.php`)
```php
Route::get('cabang/field_length', [CabangController::class, 'fieldLength']);
Route::get('cabang/{id}/delete',  [CabangController::class, 'delete']);
Route::get('cabang/index',        [CabangController::class, 'index']);
Route::get('cabang/get',          [CabangController::class, 'get']);
Route::get('cabang/export',       [CabangController::class, 'export']);
Route::get('cabang/report',       [CabangController::class, 'report']);
Route::resource('cabang', CabangController::class);
```

**Controller**: extends `MyController` and forwards grid parameters to the API:
```php
$response = Http::withHeaders($this->httpHeaders)
    ->withToken(session('access_token'))
    ->get(config('app.api_url') . 'cabang', $params);
```

**Views** (`resources/views/<module>/`)
- `index.blade.php`: jqGrid page with a toolbar (add, edit, delete, report, export)
- `_modal.blade.php`: create/edit form in a modal
- `_details.blade.php`: detail grid for header–detail transactions

---

## Security & Authorization

- **Session token**: the API `access_token` is stored in the server-side session and is not exposed to JavaScript.
- **Per-action ACL**: the `Authorized` middleware and `Myauth::hasPermission()` check user access per module and action (`index`, `store`, `update`, `destroy`, `report`, `export`, ...).
- **Role and user-level permissions**: access can be granted per role or directly to a user.
- **Password reset** uses JWT tokens that the `jwt` middleware verifies and that expire.
- **CSRF protection** and a **NoCache** middleware for authenticated pages.
- **Audit trail** through the Log Trail module.

---

## License

Released under the [MIT License](https://opensource.org/licenses/MIT).
