## End Point

POST /api/auth/login


## Request
{
    "email":"ahmed@test.com",
    "password":"password123"
}

## Success Response

### Status
200 

### Body
{
    "message":"Login successfully",
    "user":{
    "id":1,
    "name":"Ahmed Ali",
    "role":"renter"
    },
    "token":"1|xxxxxx"
}



## Error Response

### Status

401 Unauthorized

### Response
{
    "message":"Invalid credentials"
}



