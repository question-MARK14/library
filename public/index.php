<?php
use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

require '../src/vendor/autoload.php';

$app = new \Slim\App;

// Connect to the database
function connectDB() {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "library";
    try {
        $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $conn;
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// User Registration
$app->post('/user/registration', function (Request $request, Response $response) {
    $data = json_decode($request->getBody());
    $usr = $data->username;
    $pass = $data->password;

    try {
        $conn = connectDB();
        $sql = "SELECT COUNT(*) AS count FROM users WHERE username = :username";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $usr]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            return $response->withJson(["status" => "fail", "message" => "Username already exists"], 400);
        }

        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $usr, 'password' => hash('SHA256', $pass)]);
        return $response->withJson(["status" => "success", "message" => "User registered successfully"]);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()], 500);
    }
});

// User Authentication (Login for both users and admin)
$app->post('/user/login', function (Request $request, Response $response) {
    $data = json_decode($request->getBody());
    $usr = $data->username;
    $pass = $data->password;

    try {
        $conn = connectDB();
        
        if ($usr === 'admin' && $pass === 'admin123') {
            $key = 'server_hack';
            $iat = time();
            $payload = [
                'iss' => 'http://library.org',
                'aud' => 'http://library.com',
                'iat' => $iat,
                'exp' => $iat + 3600,
                "data" => ['role' => 'admin']
            ];
            $jwt = JWT::encode($payload, $key, 'HS256');
            return $response->withJson(["status" => "success", "token" => $jwt]);
        }

        $sql = "SELECT * FROM users WHERE username=:username AND password=:password";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['username' => $usr, 'password' => hash('SHA256', $pass)]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $key = 'server_hack';
            $iat = time();
            $payload = [
                'iss' => 'http://library.org',
                'aud' => 'http://library.com',
                'iat' => $iat,
                'exp' => $iat + 3600,
                "data" => ['userid' => $user['userid']]
            ];
            $jwt = JWT::encode($payload, $key, 'HS256');
            return $response->withJson(["status" => "success", "token" => $jwt]);
        } else {
            return $response->withJson(["status" => "fail", "message" => "Authentication failed"]);
        }
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});

function validateJWT($request, $response) {
    $token = $request->getHeaderLine('Authorization');
    error_log("Authorization Header: " . $token);

    if (!$token) {
        return $response->withJson(["status" => "fail", "message" => "Token not provided"], 401);
    }

    // Remove "Bearer " from the token string
    $token = str_replace('Bearer ', '', $token);

    try {
        $decoded = JWT::decode($token, new Key('server_hack', 'HS256'));
        return $decoded; 
    } catch (Exception $e) {
        return $response->withJson(["status" => "fail", "message" => "Invalid token"], 401);
    }
}

// Create new author
$app->post('/create_authors', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded; // Return error response if validation fails

    $data = json_decode($request->getBody());
    $name = $data->name;

    try {
        $conn = connectDB();
        $sql = "INSERT INTO authors (name) VALUES (:name)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $name]);
        return $response->withJson(["status" => "success", "message" => "Author created"]);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});


// Read all authors
$app->get('/read_authors', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded;

    try {
        $conn = connectDB();
        $sql = "SELECT * FROM authors";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $authors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $response->withJson($authors);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});

// Update author by ID
$app->put('/update_authors', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded;

    $data = json_decode($request->getBody());
    $authorid = $data->authorid;
    $name = $data->name;

    try {
        $conn = connectDB();
        $sql = "UPDATE authors SET name = :name WHERE authorid = :authorid";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['name' => $name, 'authorid' => $authorid]);
        return $response->withJson(["status" => "success", "message" => "Author updated"]);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});

// Delete author by ID
$app->delete('/delete_authors', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded;

    $data = json_decode($request->getBody());
    $authorid = $data->authorid;

    try {
        $conn = connectDB();
        $sql = "DELETE FROM authors WHERE authorid = :authorid";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['authorid' => $authorid]);
        return $response->withJson(["status" => "success", "message" => "Author deleted"]);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});

// Create new book
$app->post('/create_books', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded;

    $data = json_decode($request->getBody());
    $title = $data->title;
    $authorid = $data->authorid;

    try {
        $conn = connectDB();
        $sql = "INSERT INTO books (title, authorid) VALUES (:title, :authorid)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['title' => $title, 'authorid' => $authorid]);
        return $response->withJson(["status" => "success", "message" => "Book created"]);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});

// Read all books
$app->get('/read_books', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded;

    try {
        $conn = connectDB();
        $sql = "SELECT books.bookid, books.title, authors.name AS author FROM books JOIN authors ON books.authorid = authors.authorid";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $books = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $response->withJson($books);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});

// Update book by ID
$app->put('/update_books', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded;

    $data = json_decode($request->getBody());
    $bookid = $data->bookid;
    $title = $data->title;
    $authorid = $data->authorid;

    try {
        $conn = connectDB();
        $sql = "UPDATE books SET title = :title, authorid = :authorid WHERE bookid = :bookid";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['title' => $title, 'authorid' => $authorid, 'bookid' => $bookid]);
        return $response->withJson(["status" => "success", "message" => "Book updated"]);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});

// Delete book by ID
$app->delete('/delete_books', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded;

    $data = json_decode($request->getBody());
    $bookid = $data->bookid;

    try {
        $conn = connectDB();
        $sql = "DELETE FROM books WHERE bookid = :bookid";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['bookid' => $bookid]);
        return $response->withJson(["status" => "success", "message" => "Book deleted"]);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});

// Create new book author entry
$app->post('/create_book_authors', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded;

    $data = json_decode($request->getBody());
    $bookid = $data->bookid;
    $authorid = $data->authorid;

    try {
        $conn = connectDB();
        $sql = "INSERT INTO book_authors (bookid, authorid) VALUES (:bookid, :authorid)";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['bookid' => $bookid, 'authorid' => $authorid]);
        return $response->withJson(["status" => "success", "message" => "Book Author entry created"]);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});

// Read all book author entries
$app->get('/read_book_authors', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded;

    try {
        $conn = connectDB();
        $sql = "SELECT book_authors.collectionid, books.title, authors.name AS author 
                FROM book_authors 
                JOIN books ON book_authors.bookid = books.bookid 
                JOIN authors ON book_authors.authorid = authors.authorid";
        $stmt = $conn->prepare($sql);
        $stmt->execute();
        $bookAuthors = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $response->withJson($bookAuthors);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});

// Update book author entry by collectionid
$app->put('/update_book_authors', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded;

    $data = json_decode($request->getBody());

    // Check if data is properly decoded and fields are not null
    if (!isset($data->collectionid) || !isset($data->bookid) || !isset($data->authorid)) {
        return $response->withJson(["status" => "fail", "message" => "Missing required fields"]);
    }

    $collectionid = $data->collectionid;
    $bookid = $data->bookid;
    $authorid = $data->authorid;

    try {
        $conn = connectDB();
        $sql = "UPDATE book_authors SET bookid = :bookid, authorid = :authorid WHERE collectionid = :collectionid";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['bookid' => $bookid, 'authorid' => $authorid, 'collectionid' => $collectionid]);
        return $response->withJson(["status" => "success", "message" => "Book Author entry updated"]);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});


// Delete book author entry by collectionid
$app->delete('/delete_book_authors', function (Request $request, Response $response) {
    $decoded = validateJWT($request, $response);
    if ($decoded instanceof Response) return $decoded;

    $data = json_decode($request->getBody());
    $collectionid = $data->collectionid;

    try {
        $conn = connectDB();
        $sql = "DELETE FROM book_authors WHERE collectionid = :collectionid";
        $stmt = $conn->prepare($sql);
        $stmt->execute(['collectionid' => $collectionid]);
        return $response->withJson(["status" => "success", "message" => "Book Author entry deleted"]);
    } catch (PDOException $e) {
        return $response->withJson(["status" => "fail", "message" => $e->getMessage()]);
    }
});

// Run the app
$app->run();
