# API Authentication Endpoints (Sanctum)

## Register
- **Endpoint:** `POST /api/auth/register`
- **Request Body:**
```json
{
  "username": "john_doe",
  "email": "john@example.com",
  "password": "yourPassword123"
}
```
- **Success Response:**
Status: 201 Created
```json
{
  "status": "success",
  "token": "SANCTUM_TOKEN",
  "user": {
    "id": "1",
    "username": "john_doe",
    "email": "john@example.com"
  },
  "message": "Registration successful"
}
```
- **Error Response (validation):**
Status: 400 Bad Request
```json
{
  "status": "error",
  "message": "Validation error",
  "errors": ["The email has already been taken."]
}
```
- **Error Response (duplicate):**
Status: 409 Conflict
```json
{
  "status": "error",
  "message": "User already exists",
  "errors": []
}
```

## Login
- **Endpoint:** `POST /api/auth/login`
- **Request Body:**
```json
{
  "email": "john@example.com",
  "password": "yourPassword123"
}
```
- **Success Response:**
Status: 200 OK
```json
{
  "status": "success",
  "token": "SANCTUM_TOKEN",
  "user": {
    "id": "1",
    "username": "john_doe",
    "email": "john@example.com"
  },
  "message": "Login successful"
}
```
- **Error Response (invalid credentials):**
Status: 401 Unauthorized
```json
{
  "status": "error",
  "message": "Invalid credentials",
  "errors": []
}
```
- **Error Response (rate limit):**
Status: 429 Too Many Requests
```json
{
  "status": "error",
  "message": "Too many login attempts. Please try again later.",
  "errors": []
}
```

## Get Authenticated User
- **Endpoint:** `GET /api/auth/me`
- **Headers:**
  - `Authorization: Bearer SANCTUM_TOKEN`
- **Success Response:**
Status: 200 OK
```json
{
  "status": "success",
  "user": {
    "id": "1",
    "username": "john_doe",
    "email": "john@example.com"
  }
}
```

## Security Notes
- Passwords are hashed with bcrypt and never returned in responses.
- Sanctum tokens expire in 3 minutes.
- Use HTTPS in production.
- All error responses follow a consistent JSON format.
