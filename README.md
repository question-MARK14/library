# Library Management API

This repository provides a RESTful API for managing a library system. It supports user authentication, author management, book management, and book-author relationships.

---

## API Endpoints

### USER MANAGEMENT

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
  ```
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
    "token": "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vbGlicmFyeS5vcmciLCJhdWQiOiJodHRwOi8vbGlicmFyeS5jb20iLCJpYXQiOjE3MzIwMjg3MzQsImV4cCI6MTczMjAzMjMzNCwiZGF0YSI6eyJ1c2VyaWQiOjEyfX0.BCz4U3IKBejDj4LPd-9ctx1ydXWGkh_c5WUxLycPFdg"
  }
```

---

### AUTHORS MANAGEMENT
#### Create Authors
- **Description**: Create new author.
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
- **Description**: Read all authors.
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
- **Description**: Update the author.
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
- **Description**: Delete author/s.
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
- **Description**: Create new books.
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
- **Description**: Read all books.
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
- **Description**: Update books.
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
- **Description**: Delete books.
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
- **Description**: Create new book-author.
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
- **Description**: Read all book-author.
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
- **Description**: Update book-author.
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
- **Description**: Delete book-author.
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
