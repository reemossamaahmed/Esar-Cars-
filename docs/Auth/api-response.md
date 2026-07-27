# API Response Documentation

## Overview

Esar Cars API uses a unified response structure for all endpoints.

All successful and failed requests return a consistent JSON format.

This helps:

- Frontend integration
- Easier debugging
- Consistent error handling
- Better API maintainability


---

# Response Structure

## Success Response


All successful responses follow:


```json
{
    "success": true,
    "message": "Operation completed successfully",
    "data": {}
}
```


### Fields


| Field | Type | Description |
|-|-|-|
|success|boolean|Indicates request status|
|message|string|Response message|
|data|object/array|Returned data|



---

# Success Examples


## Register Success


```json
{
    "success": true,
    "message": "Registration successful",
    "data": {
        "user": {
            "id": 1,
            "name": "Ahmed Mohamed",
            "email": "ahmed@example.com"
        }
    }
}
```



---

## Login Success


```json
{
    "success": true,
    "message": "Login successful",
    "data": {
        "user": {
            "id":1,
            "name":"Ahmed Mohamed",
            "email":"ahmed@example.com"
        }
    }
}
```



---

# Error Response


All errors follow:


```json
{
    "success": false,
    "message": "Something went wrong",
    "errors": {}
}
```



Fields:


|Field|Type|Description|
|-|-|-|
|success|boolean|Always false|
|message|string|Human readable message|
|errors|object|Validation or additional errors|



---

# Validation Error


Status:

```
422 Unprocessable Entity
```


Example:


```json
{
    "success": false,
    "message": "Validation failed",
    "errors": {
        "email": [
            "The email field is required."
        ],
        "password": [
            "The password must be at least 8 characters."
        ]
    }
}
```



---

# Authentication Error


Status:

```
401 Unauthorized
```


Example:


```json
{
    "success": false,
    "message": "Unauthenticated."
}
```



Used when:

- Missing token
- Invalid token
- Expired authentication



---

# Authorization Error


Status:

```
403 Forbidden
```


Example:


```json
{
    "success": false,
    "message": "Unauthorized action."
}
```


Used when:

- User does not have permission
- Role restriction



---

# Resource Not Found


Status:

```
404 Not Found
```


Example:


```json
{
    "success": false,
    "message": "Resource not found."
}
```



Used for:

- Missing records
- Invalid routes



---

# Server Error


Status:

```
500 Internal Server Error
```


Production response:


```json
{
    "success": false,
    "message": "Something went wrong. Please try again later."
}
```


Development response may include debugging details.


---

# Localization


API supports multiple languages.

Current supported languages:

- English
- Arabic


Language is selected using:

```
Accept-Language
```



Example:


Arabic:

```http
Accept-Language: ar
```


Response:

```json
{
    "success": false,
    "message": "يجب تسجيل الدخول أولاً."
}
```



English:


```http
Accept-Language: en
```


Response:


```json
{
    "success": false,
    "message": "Unauthenticated."
}
```



---

# Exception Handling


The API handles:


## ValidationException

Used for:

- Invalid input
- Business validation rules



## AuthenticationException

Used for:

- Unauthorized users
- Missing authentication



## AuthorizationException

Used for:

- Permission errors



## ModelNotFoundException

Used for:

- Missing database records



## BusinessException

Used for:

- Custom business rules



Example:


```php
throw new BusinessException(
    'Email already verified',
    400
);
```



---

# Response Best Practices


The API always:

✅ Returns JSON responses

✅ Uses proper HTTP status codes

✅ Provides translated messages

✅ Separates validation errors

✅ Hides sensitive exceptions in production

✅ Uses one response format across all modules

