# Money Tracker API (Laravel)

Backend assessment implementation for a multi-wallet money tracker.

## Features

- Create users (no authentication)
- Create wallets per user
- Add wallet transactions (`income` or `expense`)
- View user profile with:
  - all wallets
  - each wallet balance
  - overall balance
- View single wallet with:
  - wallet balance
  - wallet transactions

## Setup

1. Install PHP 8.2+ and Composer.
2. Create a Laravel app or use these files in an existing Laravel app.
3. Configure `.env` database settings.
4. Run:

```bash
php artisan migrate
php artisan serve
```

## API Endpoints

- `POST /api/users`
- `GET /api/users/{user}`
- `POST /api/wallets`
- `GET /api/wallets/{wallet}`
- `POST /api/transactions`

## Sample Payloads

### Create User

```json
{
  "name": "Amani",
  "email": "amani@example.com"
}
```

### Create Wallet

```json
{
  "user_id": 1,
  "name": "Business Wallet"
}
```

### Create Transaction

```json
{
  "wallet_id": 1,
  "type": "income",
  "amount": 1500,
  "description": "Client payment"
}
```
