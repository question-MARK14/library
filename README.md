# Library Management API

This repository provides a RESTful API for managing a library system. It supports user authentication, author management, book management, and book-author relationships.

---

## API Endpoints

### USER MANAGEMENT
#### User Registration
- **Description**: This endpoint allows new users to register by providing a unique username and password.
- **Method**: `POST`
- **Endpoint**: `/user/registration`
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
  "message": "User registered successfully"
}
```

---

### User Login
- **Description**: This endpoint allows registered users to login. It verifies the credentials and generates a JWT token for subsequent requests. The token must be included in the Authorization header for protected endpoints.
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
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIwMjg3MzQsImV4cCI6MTczMjAzMjMzNCwiZGF0YSI6eyJ1c2VyaWQiOjEyfX0.BCz4U3IKBejDj4LPd-9ctx1ydXWGkh_c5WUxLycPFdg"
  }
```

---

### AUTHORS MANAGEMENT
#### Create Authors
- **Description**: This endpoint allows the creation of a new author by providing the author's name.
- **Method**: `POST`
- **Endpoint**: `/create_authors`
- **Payload**:
  ```
  {
  "name":"Mark Angelo V. Ramos"
  }
  ```
**Response**:
```
  {
    "status": "success",
    "message": "Author created"
  }
```

---

#### Read Authors
- **Description**: This endpoint retrieves all authors in the database. The response includes a list of author IDs and their respective names. 
- **Method**: `GET`
- **Endpoint**: `/read_authors`
- **Payload**:
  ```
  ```
**Response**:
```
  [
  {
    "authorid": 1,
    "name": "Mark Ramos"
  },
  {
    "authorid": 3,
    "name": "Pancit Palabok"
  },
  {
    "authorid": 4,
    "name": "Diko Alam"
  },
  {
    "authorid": 5,
    "name": "Wala ng pera"
  },
  {
    "authorid": 7,
    "name": "Diko Alam"
  },
  {
    "authorid": 8,
    "name": "Alam ko na"
  },
  {
    "authorid": 10,
    "name": "Mali Gaya"
  },
  {
    "authorid": 11,
    "name": "Vina Shura"
  },
  {
    "authorid": 13,
    "name": "Mark Angelo V. Ramos"
  }
]
```

---

#### Update Authors
- **Description**: This endpoint updates the name of an existing author identified by authorid. It is used to correct or modify author records.
- **Method**: `PUT`
- **Endpoint**: `/update_authors`
- **Payload**:
  ```
  {
    "authorid":13,
    "name":"Ako si Mark"
  }
  ```
**Response**:
```
  {
    "status": "success",
    "message": "Author updated"
  }
```

---


#### Delete Authors
- **Description**: This endpoint removes an author from the database using their authorid. 
- **Method**: `DELETE`
- **Endpoint**: `/delete_authors`
- **Payload**:
  ```
  {
    "authorid":13
  }
  ```
**Response**:
```
  {
    "status": "success",
    "message": "Author deleted"
  }
```

---


### BOOKS MANAGEMENT
#### Create Books
- **Description**: Adds a new book to the library database. Requires a title and the authorid of the corresponding author.
- **Method**: `POST`
- **Endpoint**: `/create_books`
- **Payload**:
  ```
  {
    "title":"The Earth is Flat",
    "authorid":1
  }
  ```
**Response**:
```
  {
    "status": "success",
    "message": "Book created"
  }
```

---

#### Read Books
- **Description**: Retrieves all books stored in the database. Includes book IDs, titles, and their associated author names. 
- **Method**: `GET`
- **Endpoint**: `/read_books`
- **Payload**:
  ```
  ```
**Response**:
```
  {
    "status": "success",
    "message": "Book deleted"
  }
```

---

#### Update Books
- **Description**: Updates the title or associated author of an existing book identified by bookid.
- **Method**: `PUT`
- **Endpoint**: `/update_books`
- **Payload**:
  ```
  {
    "bookid":6,
    "title":"The Earth is Round",
    "authorid":1
  }
  ```
**Response**:
```
  {
    "status": "success",
    "message": "Book updated"
  }
```

---

#### Delete Books
- **Description**: Deletes a book from the database using its bookid.
- **Method**: `DELETE`
- **Endpoint**: `/delete_books`
- **Payload**:
  ```
  {
    "bookid":6
  }
  ```
**Response**:
```
  {
    "status": "success",
    "message": "Book deleted"
  }
```

--

### BOOKS-AUTHORS MANAGEMENT
#### Create Book-Author
- **Description**: Links an existing book to an author.
- **Method**: `POST`
- **Endpoint**: `/create_book_authors`
- **Payload**:
  ```
  {
    "bookid":1,
    "authorid":7
  }
  ```
**Response**:
```
  {
    "status": "success",
    "message": "Book Author entry created"
  }
```

---

#### Read Books
- **Description**: Fetches all book-author relationships in the database. Each entry includes the book's title and the author's name.
- **Method**: `GET`
- **Endpoint**: `/read_book_authors`
- **Payload**:
  ```
  ```
**Response**:
```
  [
    {
      "collectionid": 5,
      "title": "Pangarap na Mahirap Abutin",
      "author": "Diko Alam"
    }
  ]
```

---

#### Update Book-Author
- **Description**: Modifies an existing book-author relationship by updating the bookid or authorid in a specific entry.
- **Method**: `PUT`
- **Endpoint**: `/update_book_authors`
- **Payload**:
  ```
  {
    "collectionid":5,
    "bookid":1,
    "authorid":5
  }
  ```
**Response**:
```
  {
    "status": "success",
    "message": "Book Author entry updated"
  }
```

---

#### Delete Book-Author
- **Description**: Removes a book-author relationship from the database.
- **Method**: `DELETE`
- **Endpoint**: `/delete_book_authors`
- **Payload**:
  ```
  {
    "collectionid":5
  }
  ```
**Response**:
```
  {
    "status": "success",
    "message": "Book Author entry deleted"
  }
```
