# Authentication


## User Types

The system supports:

| Role | Description |
|---|---|
| renter | Can rent cars |
| owner | Can add and manage cars |
| admin | Manage system |


## Authentication Flow

1. User registers
2. User logs in
3. API returns token
4. Client sends token with requests


Example Header:

Authorization: Bearer eyJ0eXAiOiJK...
