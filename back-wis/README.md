# Project E-Recruitment
This is a project for an E-Recruitment system.
## Installation Instructions
1. Clone the repository:
2. Navigate to the project directory:
3. Install Composer dependencies:
```bash
  composer install
```
6. Copy the example environment file:
```bash
  cp .env.example .env
```
7. Generate the application key:

```bash
  php artisan key:generate
```
8. Run the migrations and seed the database:

```bash
  php artisan migrate --seed
```
9. Set up the storage link:
```bash
  php artisan storage:link
```
10. Run the application:
```bash
  php artisan serve
```

# Admin account
Access the admin panel:
```bash
  http://localhost:8000/admin
```
- Email: admin@gmail.com
- Password: passer
- Role: Admin
