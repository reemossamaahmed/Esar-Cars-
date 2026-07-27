# API Endpoints Documentation

## Base URL

```
https://api.esar-cars.com/api/v1/auth
```

For local development:

```
http://localhost:8000/api/v1/auth
```


---

# Authentication Headers

## Public Requests

Required:

```
Accept: application/json
Content-Type: application/json
Accept-Language: ar | en

```

---

## Protected Requests

Required:

```
Authorization: Bearer {token}
```

Example:

```
Authorization: Bearer eyJ0eXAiOiJKV1Qi...
```
---


# Authentication Endpoints

| Method | Endpoint                           | Description                      |
| ------ | ---------------------------------- | -------------------------------- |
| POST   | `/api/v1/auth/register`            | Register new user                |
| POST   | `/api/v1/auth/verify-email`        | Verify email OTP                 |
| POST   | `/api/v1/auth/resend-verification` | Resend verification OTP          |
| POST   | `/api/v1/auth/login`               | Login with email/password        |
| POST   | `/api/v1/auth/google`              | Login with Google                |
| POST   | `/api/v1/auth/set-password`        | Create password for Google users |
| POST   | `/api/v1/auth/forgot-password`     | Send reset password OTP          |
| POST   | `/api/v1/auth/reset-password`      | Reset password                   |
| PUT    | `/api/v1/auth/change-password`     | Change current password          |
| GET    | `/api/v1/auth/profile`             | Show Profile                     |
| PUT    | `/api/v1/auth/profile`             | Update Profile                   |
| POST   | `/api/v1/auth/logout`              | Logout                           |
| POST   | `/api/v1/auth/set-password`        | Set Password                     |


---

# Authentication Endpoints


# 1. Register

Create a new renter account.


## Endpoint

```
POST /register
```


## Authentication

```
Public
```


## Request Body

```json
{
    "name": "Ahmed Mohamed",
    "email": "ahmed@example.com",
    "phone": "01000000000",
    "password": "Password123"
}
```


## Validation

| Field | Rule |
|-|-|
|name|required|
|email|required|email|unique|
|phone|nullable|
|password|required|min:8|


## Success Response

Status:

```
201 Created
```


Response:

```json
{
    "success": true,
    "message": "Registration successful",
    "data": {
        "user": {
            "id":1,
            "name":"Ahmed Mohamed",
            "email":"ahmed@example.com"
        }
    }
}
```


## Errors


### Email Exists

Status:

```
422
```


Response:

```json
{
    "success":false,
    "message":"Email already exists"
}
```



---


# 2. Verify Email


Verify user email using OTP.


## Endpoint

```
POST /verify-email
```


## Authentication

```
Public
```


## Request

```json
{
    "email":"ahmed@example.com",
    "otp":"123456"
}
```


## Success Response


```json
{
    "success":true,
    "message":"Email verified successfully"
}
```



## Possible Errors


| Error | Description |
|-|-|
|Invalid OTP|OTP is incorrect|
|Expired OTP|OTP expired|
|Already Verified|Email already verified|



---


# 3. Resend Verification Email


Send new verification OTP.


## Endpoint


```
POST /resend-verification
```


## Request


```json
{
    "email":"ahmed@example.com"
}
```


## Success


```json
{
    "success":true,
    "message":"Verification email sent"
}
```



---


# 4. Login


Login using email and password.


## Endpoint


```
POST /login
```


## Request


```json
{
    "email":"ahmed@example.com",
    "password":"Password123"
}
```



## Success Response


```json
{
    "success":true,
    "message":"Login successful",
    "data":{
        "user":{
            "id":1,
            "name":"Ahmed"
        }
    }
}
```


Token is returned using authentication cookie/token strategy.



---


# 5. Google Login


Login using Google Identity Services.


## Endpoint


```
POST /google
```


## Request


```json
{
    "id_token":"GOOGLE_ID_TOKEN"
}
```


## Success Response


```json
{
    "success":true,
    "message":"Google login successful",
    "data":{
        "user":{
            "id":1,
            "email":"google@gmail.com"
        }
    }
}
```


---


# 6. Set Password


Used by Google users to create password.


## Endpoint


```
POST /set-password
```


## Authentication


```
Required
```


## Headers


```
Authorization: Bearer token
```


## Request


```json
{
    "password":"Password123",
    "password_confirmation":"Password123"
}
```


## Success


```json
{
    "success":true,
    "message":"Password has been set successfully"
}
```



---


# 7. Forgot Password


Generate password reset OTP.


## Endpoint


```
POST /forgot-password
```


## Request


```json
{
    "email":"ahmed@example.com"
}
```


## Success


```json
{
    "success":true,
    "message":"Password reset email sent"
}
```



---


# 8. Reset Password


Reset password using OTP.


## Endpoint


```
POST /reset-password
```


## Request


```json
{
    "email":"ahmed@example.com",
    "otp":"123456",
    "password":"NewPassword123",
    "password_confirmation":"NewPassword123"
}
```


## Success


```json
{
    "success":true,
    "message":"Password reset successfully"
}
```



---


# 9. Change Password


Change password for authenticated users.


## Endpoint


```
POST /change-password
```


## Authentication


```
Required
```


## Headers


```
Authorization: Bearer token
```


## Request


```json
{
    "current_password":"OldPassword123",
    "password":"NewPassword123",
    "password_confirmation":"NewPassword123"
}
```


## Success


```json
{
    "success":true,
    "message":"Password changed successfully"
}
```



---


# Common Error Responses


## Validation Error


Status:

```
422
```


Example:


```json
{
    "success":false,
    "message":"Validation failed",
    "errors":{
        "email":[
            "The email field is required"
        ]
    }
}
```



---


## Unauthorized


Status:

```
401
```


```json
{
    "success":false,
    "message":"Unauthenticated"
}
```



---


## Forbidden


Status:

```
403
```


```json
{
    "success":false,
    "message":"Unauthorized action"
}
```



---


# HTTP Status Codes


| Code | Meaning |
|-|-|
|200|Success|
|201|Created|
|400|Bad Request|
|401|Unauthenticated|
|403|Forbidden|
|404|Not Found|
|422|Validation Error|
|500|Server Error|

