# Register User

## Endpoint

POST /api/v1/auth/register


## Request Body

{
    "name":"string",
    "phone":"string",
    "email":"string",
    "password":"string",
    "password_confirmation":"string"
}



## Validation

| Field    | Rule     |        |           |
| -------- | -------- | ------ | --------- |
| name     | required | string |           |
| email    | required | email  | unique    |
| phone    | nullable | string |           |
| password | required | min:8  | confirmed |


## Success Response

Status: 201

{
    "success": true,
    "message": "Registered successfully",
    "data": {
        "user": {
            "id": 1,
            "name": "Reem",
            "email": "reem@test.com",
            "roles": [
                "renter"
            ],
            "status": "active"
        },
        "token": "1|xxxxx"
    }
}

## Validation Errors

Status: 422

