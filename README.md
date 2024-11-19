# Library Management API

This repository provides a RESTful API for managing a library system. It supports user authentication, author management, book management, and book-author relationships.

---

## API Endpoints

### User Management

#### User Registration
- **Description**: Register a new user.
- **Method**: `POST`
- **Endpoint**: `/user/registration`
- **Payload**:
  ```
  {
  "username":"question-MARK14",
  "password":"period"
  }
**Response**:
```
{
  "status": "success",
  "message": "User registered successfully"
}
```

---

### User Login:
- **Description**: Authenticate admin and user.
- **Method**: `POST`
- **Endpoint**: `/user/login`
- **Payload**:
  ```
  {
  "username":"question-MARK14",
  "password":"period"
  }
  ```
**Response**:
```
{
  "status": "success",
  "token": 
"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIwMjg3MzQsImV4cCI6MTczMjAzMjMzNCwiZGF0YSI6eyJ1c2VyaWQiOjEyfX0.BCz4U3IKBejDj4LPd-9ctx1ydXWGkh_c5WUxLycPFdg"
}
```

