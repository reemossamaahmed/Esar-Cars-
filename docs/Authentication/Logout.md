## End Point

POST /api/auth/register


## Request
{
    "name":"Ahmed Ali",
    "email":"ahmed@test.com",
    "phone":"010000000",
    "password":"password123",
    "password_confirmation":"password123"
}

## Validation

| Field    | Rule     |        |           |
| -------- | -------- | ------ | --------- |
| name     | required | string |           |
| email    | required | email  | unique    |
| phone    | nullable | string |           |
| password | required | min:8  | confirmed |


## Success Response
### Status
201 Created
### Body
{
"message":"Registered successfully",
"user":{
"id":1,
"name":"Ahmed Ali",
"email":"ahmed@test.com"
},
"token":"1|xxxxxxxx"
}



