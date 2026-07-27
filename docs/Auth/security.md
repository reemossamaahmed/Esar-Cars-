# Authentication Security Documentation

## Overview

Security is a critical part of Esar Cars authentication system.

The authentication module implements multiple security layers to protect:

- User accounts
- Passwords
- Authentication tokens
- OTP codes
- Email verification
- Background processes


---

# Password Security


## Password Hashing


User passwords are never stored as plain text.


Before storing:


```
User Password

      |
      ↓

Hashing Algorithm

      |
      ↓

Database
```


Laravel uses secure password hashing:


```php
Hash::make($password)
```



Example:


Original:

```
Password123
```


Stored:


```
$2y$12$xxxxxxxxxxxxxxxxxxxx
```



The original password cannot be recovered.



---

# Password Verification


During login:


```
User Password

      |
      ↓

Hash Comparison

      |
      ↓

Authentication Result
```


Laravel verifies using:


```php
Hash::check()
```



---

# Google User Password Security


Google users do not create passwords initially.


Initial state:


```
provider = google

has_password = false
```



The system creates a random internal password:


```php
Str::random(32)
```



Purpose:


- Maintain database consistency
- Prevent empty password fields
- Ensure user cannot login with unknown password



---

# OTP Security


OTP is used for:


- Email verification
- Password reset



---

# OTP Expiration


Every OTP has expiration time.


Example:


```
Created At:

12:00


Expires At:

12:10
```



After expiration:


```
OTP = Invalid
```



---

# OTP Validation


The system checks:


```
Receive OTP

     |
     ↓

Find Latest OTP

     |
     ↓

Check Expiration

     |
     ↓

Compare Code

     |
     ↓

Accept / Reject
```



---

# OTP Abuse Protection


The system prevents:


- Unlimited OTP requests
- Reusing old OTPs
- Using expired OTPs



Recommended production improvements:


- Maximum resend attempts
- Cooldown period
- IP based throttling



---

# Authentication Token Security


The application uses token-based authentication.


Tokens are required for protected routes.


Example:


```
Authorization: Bearer {token}
```



---

# Protected Routes


Protected APIs use authentication middleware.


Example:


```php
auth:sanctum
```



Only authenticated users can access these routes.



---

# Token Revocation


Sensitive actions revoke old tokens.


Examples:


- Password change
- Password reset
- Security actions



Purpose:


If a token is stolen:


```
Old Token

      ↓

Revoked

      ↓

Cannot Access API
```



---

# Google Authentication Security


Google authentication follows secure practices.



## Token Verification


The backend verifies Google ID Token.


The API does not trust client-provided information.


Flow:


```
Client Token

      |
      ↓

Google Verification

      |
      ↓

User Creation/Login
```



---

# Email Verification Security


Normal users must verify email before activation.


Initial state:


```
status = pending
```



After successful verification:


```
status = active
```



Benefits:


- Prevent fake accounts
- Validate ownership of email
- Improve account security



---

# Queue Security


Emails are processed using Laravel Queue.


Benefits:


- Prevent blocking requests
- Retry failed emails
- Isolate external services



---

# Queue Retry Protection


Jobs define:


```php
public int $tries = 3;
```



Failed jobs:


```
Attempt 1

Attempt 2

Attempt 3

        ↓

failed_jobs table
```



---

# Exception Security


The API does not expose sensitive system information.



Production response:


```json
{
    "success":false,
    "message":"Something went wrong. Please try again later."
}
```



Internal errors are:

- Logged
- Reported
- Hidden from users



---

# Localization Security


All error messages are translated.


The API does not expose:

- Database errors
- SQL queries
- Stack traces
- Internal file paths



---

# Rate Limiting


Rate limiting protects sensitive endpoints.


Protected endpoints:


```
Login

Google Login

Forgot Password

Resend Verification
```



Purpose:


Prevent:

- Brute force attacks
- OTP abuse
- Account enumeration



---

# Database Security


Implemented:


✅ Unique email constraint

✅ Unique Google ID

✅ Unique phone constraint

✅ Foreign key constraints

✅ Data validation before storage



---

# Input Validation


All incoming requests are validated using Form Requests.


Example:


```
RegisterRequest

LoginRequest

ResetPasswordRequest
```



Benefits:


- Cleaner controllers
- Consistent validation
- Prevent invalid data



---

# Account Status Security


Users have controlled account states:


```
pending

active

inactive

suspended
```



Each status affects authentication behavior.



Example:


Suspended user:


```
Login blocked
```



---

# Security Checklist


Implemented:


| Feature | Status |
|-|-|
|Password Hashing|✅|
|OTP Expiration|✅|
|Email Verification|✅|
|Google Token Verification|✅|
|Token Authentication|✅|
|Exception Protection|✅|
|Queue Retry|✅|
|Input Validation|✅|
|Localization|✅|
|Role Based Access|✅|


---

# Future Security Improvements


Possible enhancements:


- Two Factor Authentication (2FA)
- Login history
- Device management
- Suspicious login alerts
- Captcha protection
- Security notifications
- Password strength meter


---

# Summary


Esar Cars authentication system provides:


✅ Secure password handling

✅ Protected authentication flow

✅ Verified user identities

✅ Secure Google integration

✅ Background email processing

✅ Controlled error handling

✅ Production-ready architecture
