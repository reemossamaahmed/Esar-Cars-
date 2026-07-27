# Authentication Documentation

## Overview

The Authentication module provides a complete and secure authentication system for the Esar Cars platform.

The module supports multiple authentication methods, user verification, password management, secure API access, and centralized error handling.

## Features

* User registration
* Email verification using OTP
* Resend email verification
* Login with email and password
* Google OAuth authentication
* Password reset using OTP
* Password change
* Set password for Google users
* Token-based authentication
* Queue-based email processing
* Rate limiting protection
* Localization support (Arabic / English)
* Unified API response handling
* Centralized exception handling

---

# Authentication Architecture

The authentication system follows a service-based architecture.

```
Controller
    |
    ↓
Form Request Validation
    |
    ↓
Auth Service
    |
    ↓
Models / Database
    |
    ↓
Events
    |
    ↓
Listeners
    |
    ↓
Jobs
    |
    ↓
Mail
```

## Benefits

* Separation of responsibilities
* Clean and maintainable code
* Easy testing
* Scalable architecture

---

# Authentication Types

The system supports two authentication providers.

---

## 1. Email & Password Authentication

Normal users register using:

```
email
password
```

User properties:

```
provider = null

has_password = true
```

---

## 2. Google Authentication

Users can login using Google Identity Services.

Google users are created with:

```
provider = google

google_id = google user id

has_password = false
```

Google users can create a password later using:

```
Set Password API
```

---

# Authentication Endpoints

| Method | Endpoint                           | Description                   |
| ------ | ---------------------------------- | ----------------------------- |
| POST   | `/api/v1/auth/register`            | Register new user             |
| POST   | `/api/v1/auth/verify-email`        | Verify email OTP              |
| POST   | `/api/v1/auth/resend-verification` | Resend verification OTP       |
| POST   | `/api/v1/auth/login`               | Login with email/password     |
| POST   | `/api/v1/auth/google`              | Login with Google             |
| POST   | `/api/v1/auth/set-password`        | Set password for Google users |
| POST   | `/api/v1/auth/forgot-password`     | Send password reset OTP       |
| POST   | `/api/v1/auth/reset-password`      | Reset password                |
| POST   | `/api/v1/auth/change-password`     | Change password               |
| POST   | `/api/v1/auth/logout`              | Logout user                   |

---

# Registration Flow

## Endpoint

```
POST /api/v1/auth/register
```

## Request

```json
{
    "name": "Ahmed Mohamed",
    "email": "ahmed@example.com",
    "phone": "01000000000",
    "password": "Password123",
    "password_confirmation": "Password123"
}
```

## Process

1. Validate user input.
2. Check if email already exists.
3. Create user account.
4. Assign default role.
5. Generate email verification OTP.
6. Dispatch `UserRegisteredEvent`.
7. Send verification email through queue.

## Flow

```
Register Request
        |
        ↓
Create User
        |
        ↓
Create Email Verification OTP
        |
        ↓
UserRegisteredEvent
        |
        ↓
Listener
        |
        ↓
SendVerificationEmailJob
        |
        ↓
Email
```

---

# User Verification Status

Before verification:

```
status = pending

email_verified_at = null
```

After successful verification:

```
status = active

email_verified_at = timestamp
```

---

# Email Verification

## Endpoint

```
POST /api/v1/auth/verify-email
```

## Request

```json
{
    "email": "ahmed@example.com",
    "otp": "123456"
}
```

## OTP Validation Rules

The OTP must be:

* Correct
* Not expired
* Not already used

After successful verification:

```
status = active

email_verified_at = timestamp
```

---

# Resend Verification Email

## Endpoint

```
POST /api/v1/auth/resend-verification
```

## Request

```json
{
    "email": "ahmed@example.com"
}
```

## Process

```
Request
   |
   ↓
Generate New OTP
   |
   ↓
VerificationEmailResentEvent
   |
   ↓
Listener
   |
   ↓
SendVerificationEmailJob
   |
   ↓
Email
```

---

# Login

## Endpoint

```
POST /api/v1/auth/login
```

## Request

```json
{
    "email": "ahmed@example.com",
    "password": "Password123"
}
```

## Authentication Process

```
Email
 |
 ↓
Find User
 |
 ↓
Check Password
 |
 ↓
Check Account Status
 |
 ↓
Generate Token
 |
 ↓
Return User Data
```

---

## Google User Restriction

If the user registered with Google only:

```
provider = google

has_password = false
```

Password login is not allowed.

Example response:

```json
{
    "success": false,
    "message": "This account uses Google login"
}
```

---

# Google Authentication

## Endpoint

```
POST /api/v1/auth/google
```

## Request

```json
{
    "id_token": "google_token"
}
```

## Flow

```
Google ID Token
        |
        ↓
Verify Token With Google
        |
        ↓
Get Google User Data
        |
        ↓
Find Existing Account
        |
        ↓
Create / Link User
        |
        ↓
Generate Authentication Token
```

---

# Google User Creation

New Google users are created with:

```
name

email

google_id

provider = google

avatar

status = active

email_verified_at = now()

has_password = false
```

---

# Set Password For Google Users

Google users can create a password after login.

## Endpoint

```
POST /api/v1/auth/set-password
```

## Request

```json
{
    "password": "Password123",
    "password_confirmation": "Password123"
}
```

Before:

```
provider = google

has_password = false
```

After:

```
provider = google

has_password = true
```

After setting password:

User can:

* Login using email/password
* Use forgot password
* Change password

---

# Forgot Password

## Endpoint

```
POST /api/v1/auth/forgot-password
```

## Request

```json
{
    "email": "ahmed@example.com"
}
```

## Process

```
Request
 |
 ↓
Check User
 |
 ↓
Generate OTP
 |
 ↓
Create PasswordOtp
 |
 ↓
PasswordResetRequestedEvent
 |
 ↓
Queue Job
 |
 ↓
Send Email
```

Google users without passwords cannot request password reset.

---

# Reset Password

## Endpoint

```
POST /api/v1/auth/reset-password
```

## Request

```json
{
    "email": "ahmed@example.com",
    "otp": "123456",
    "password": "NewPassword123",
    "password_confirmation": "NewPassword123"
}
```

## Validation

* OTP exists
* OTP is correct
* OTP is not expired

After reset:

```
Password updated

Old tokens revoked
```

---

# Change Password

## Endpoint

```
POST /api/v1/auth/change-password
```

## Request

```json
{
    "current_password": "OldPassword123",
    "password": "NewPassword123",
    "password_confirmation": "NewPassword123"
}
```

## Process

```
Verify Current Password
        |
        ↓
Update Password
        |
        ↓
Revoke Other Tokens
```

---

# Logout

## Endpoint

```
POST /api/v1/auth/logout
```

Removes the current authentication token.

---

# Authentication Token

The system uses Laravel Sanctum for API authentication.

## Header

```
Authorization: Bearer {token}
```

Protected routes require:

```
auth:sanctum
```

middleware.

---

# Queue Email System

Email sending is handled asynchronously using Laravel Queue.

## Architecture

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

Implemented Jobs:

```
SendVerificationEmailJob

SendPasswordResetEmailJob
```

Job configuration:

```php
public int $tries = 3;

public int $backoff = 60;
```

Meaning:

* Retry failed emails 3 times.
* Wait 60 seconds between retries.

---

# Localization

Supported languages:

```
Arabic
English
```

Request header:

Arabic:

```
Accept-Language: ar
```

English:

```
Accept-Language: en
```

All messages are managed using Laravel localization.

---

# API Response Format

## Success

```json
{
    "success": true,
    "message": "Success",
    "data": {}
}
```

## Error

```json
{
    "success": false,
    "message": "Error message",
    "errors": {}
}
```

---

# Security Features

Implemented:

✅ Password hashing
✅ OTP expiration
✅ OTP reuse prevention
✅ Google token verification
✅ Rate limiting
✅ Authentication middleware
✅ Role-based authorization
✅ Unified exception handling
✅ Localization support
✅ Device token management
✅ Token revocation after password changes

---

# Future Improvements

Possible extensions:

* Two-factor authentication
* Additional social login providers
* Login history
* Suspicious login detection
* Email notification center
* Remember device feature
