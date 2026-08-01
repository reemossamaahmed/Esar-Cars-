# 🚗 Esar Cars Backend API

A professional backend system for a car rental platform built with Laravel.

The platform connects:

- Renters who want to rent cars
- Owners / Partners who provide cars for rental

The system provides secure authentication, user management, car management, booking workflow, payments, and scalable API architecture.


---

# 📌 Project Overview

Esar Cars is a bilingual car rental platform supporting:

- Arabic (RTL)
- English (LTR)

The backend is built as a RESTful API following clean architecture principles.

The system focuses on:

- Security
- Scalability
- Maintainability
- Performance
- Clean code practices



---

# 🚀 Features


## Authentication

✅ User registration

✅ Email verification using OTP

✅ Resend verification email

✅ Login with email/password

✅ Google OAuth login

✅ Password reset

✅ Change password

✅ Set password for Google users

✅ Token-based authentication



---

## User Management

✅ Multiple user roles

✅ Account status management

✅ Profile management

✅ Avatar support

✅ Localization support



---

## Email System

Implemented using Laravel Queue:


```
Event

 ↓

Listener

 ↓

Job

 ↓

Mail

 ↓

User
```


Features:

✅ Verification emails

✅ Password reset emails

✅ Retry mechanism

✅ Failed jobs handling



---

# 🏗 Architecture


The project follows a clean backend structure:


```
Controller

    ↓

Form Request

    ↓

Service Layer

    ↓

Models

    ↓

Events

    ↓

Jobs

    ↓

Mail
```


Benefits:

- Separation of responsibilities
- Easy testing
- Maintainable code
- Scalable modules



---

# 🛠 Tech Stack


## Backend

- Laravel
- PHP
- MySQL
- REST API


## Authentication

- Laravel Sanctum
- Google Identity Services


## Authorization

- Spatie Laravel Permission


## Queue

- Laravel Queue
- Database Queue Driver


## Email

- Laravel Mail


## Tools

- Composer
- Git
- Apidog API Testing



---

# 📂 Project Structure


```
app/

├── Http/
│   ├── Controllers/
│   ├── Requests/
│   └── Middleware/


├── Services/


├── Models/


├── Events/


├── Listeners/


├── Jobs/


├── Mail/


database/

├── migrations/


routes/

├── api.php


docs/

├── authentication.md

├── api-endpoints.md

├── api-response.md

├── queue-system.md

├── google-authentication.md

└── security.md

```


---

# ⚙️ Installation


## 1. Clone Repository


```bash
git clone https://github.com/username/esar-cars.git
```


---

## 2. Install Dependencies


```bash
composer install
```


---

## 3. Environment Setup


Copy environment file:


```bash
cp .env.example .env
```


Generate application key:


```bash
php artisan key:generate
```



---

## 4. Configure Database


Update `.env`:


```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=esar_cars
DB_USERNAME=root
DB_PASSWORD=
```



---

## 5. Run Migrations


```bash
php artisan migrate
```



---

## 6. Create Seeder


```bash
php artisan db:seed
```



---

# 📧 Queue Setup


The project uses database queue driver.


Configure:


```env
QUEUE_CONNECTION=database
```



Create queue tables:


```bash
php artisan queue:table

php artisan queue:failed-table

php artisan migrate
```



Run worker:


```bash
php artisan queue:work
```



---

# 🌍 Localization


Supported languages:


```
English

Arabic
```



Send language header:


```http
Accept-Language: en
```


or:


```http
Accept-Language: ar
```



---

# 🔐 Authentication


Protected routes require:


```http
Authorization: Bearer {token}
```



Example:


```
GET /api/profile
```



---

# 📚 API Documentation


Detailed documentation:


| Document | Description |
|-|-|
|authentication.md|Authentication flow|
|api-endpoints.md|API endpoints|
|api-response.md|Response structure|
|queue-system.md|Queue architecture|
|google-authentication.md|Google OAuth|
|security.md|Security details|



---

# 🧪 Testing


API testing can be performed using:


- Apidog
- Postman


Recommended flow:


```
Register

 ↓

Verify Email

 ↓

Login

 ↓

Access Protected APIs
```



---

# 🔒 Security Features


Implemented:


✅ Password hashing

✅ OTP expiration

✅ Google token verification

✅ Rate limiting

✅ Token authentication

✅ Exception handling

✅ Input validation

✅ Queue retry system

✅ Role based authorization



---

# 📈 Future Roadmap


Planned features:


- Car management module
- Rental booking system
- Payment integration
- Owner dashboard
- Reviews and ratings
- Notifications
- Certificates
- Advanced reporting



---

# 👩‍💻 Developer


Backend Developer:

**Reem Ossama**


Specialized in:

- Laravel Backend Development
- REST API Design
- Authentication Systems
- Database Design
- Clean Architecture



---

# 📄 License


This project is currently private.
