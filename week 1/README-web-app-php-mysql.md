# Web Application Development - PHP & MySQL

## Overview

A web application is an internet-based program that works across two sides:

- **Frontend (Client-side):** HTML, CSS, JavaScript — what the user sees in the browser
- **Backend (Server-side):** PHP — what the server processes, like logic, data, and security
- **Database:** MySQL — where data is stored persistently

```
Browser  <---->  PHP (Server)  <---->  MySQL (Database)
 (HTML)          (Logic)              (Storage)
```

## 1. Why PHP + MySQL

| PHP | MySQL |
|-----|-------|
| Handles the logic | Stores the data |
| Builds dynamic pages | Manages tables |
| Works with forms, sessions, files | Provides fast, queryable data |

Example: when you log into a website, PHP reads the username and password you entered, then asks MySQL "does this user exist?"

## 2. Server Environment

To run PHP + MySQL code, you need:

- **Web server:** Apache or Nginx
- **PHP interpreter**
- **MySQL / MariaDB server**

These are usually bundled together in tools like:

- **XAMPP** (Windows, Mac, Linux)
- **MAMP** (Mac)
- **WAMP** (Windows)
- **LAMP stack** (Linux, Apache, MySQL, PHP) — used in production servers

## 3. Database Connection

The modern approaches are **MySQLi** or **PDO**.

### Example — MySQLi (Object-Oriented)

```php
<?php
$servername = "localhost";
$username   = "root";
$password   = "";
$dbname     = "school_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "Connected successfully to the database!";
?>
```

### Example — PDO (same idea, but often preferred)

```php
<?php
try {
    $conn = new PDO("mysql:host=localhost;dbname=school_db", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connection successful!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
```

## 4. CRUD — The Four Core Operations

CRUD = **Create, Read, Update, Delete** — the foundation of almost every web project.

### Create — Insert data (INSERT)

```php
$sql = "INSERT INTO students (name, age) VALUES ('Xuudi', 22)";
$conn->query($sql);
```

### Read — Retrieve data (SELECT)

```php
$sql = "SELECT * FROM students";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    echo $row["name"] . " - " . $row["age"] . "<br>";
}
```

### Update — Modify data (UPDATE)

```php
$sql = "UPDATE students SET age = 23 WHERE name = 'Xuudi'";
$conn->query($sql);
```

### Delete — Remove data (DELETE)

```php
$sql = "DELETE FROM students WHERE name = 'Xuudi'";
$conn->query($sql);
```

## 5. Prepared Statements — Data Security

Never insert user input directly into a query — this leads to **SQL Injection**, one of the most dangerous and common vulnerabilities.

❌ **Dangerous:**
```php
$sql = "SELECT * FROM users WHERE username = '$username'";
```

✅ **Safe (Prepared Statement):**
```php
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
```

## 6. Forms — Getting Input from the User

```html
<form method="POST" action="save.php">
    <input type="text" name="name" placeholder="Name">
    <input type="number" name="age" placeholder="Age">
    <button type="submit">Save</button>
</form>
```

```php
// save.php
$name = $_POST['name'];
$age  = $_POST['age'];

$stmt = $conn->prepare("INSERT INTO students (name, age) VALUES (?, ?)");
$stmt->bind_param("si", $name, $age);
$stmt->execute();
```

- `$_POST` — data submitted via a form with `method="POST"`
- `$_GET` — data submitted via the URL (`?id=5`)

## 7. Sessions — Remembering the User

```php
session_start();
$_SESSION['username'] = $username;

// On another page
session_start();
if (isset($_SESSION['username'])) {
    echo "Welcome back, " . $_SESSION['username'];
}
```

## 8. Sample Project Structure

```
my-project/
├── index.php          → Home page
├── config.php         → Database connection
├── login.php          → Login page
├── register.php       → Registration
├── dashboard.php      → Logged-in user page
├── logout.php         → Logout
└── css/
    └── style.css
```

## 9. General Steps to Build an App

1. Design the database (tables, `id`, foreign keys)
2. Create `config.php` to connect to MySQL
3. Build the HTML forms (login, register, add data)
4. Write the PHP that accepts form input and inserts it into the database
5. Use prepared statements to keep it secure
6. Use sessions to remember the logged-in user
7. Test the app and fix bugs (debugging)

## 10. Common Mistakes

1. Forgetting `session_start();` at the top of the page
2. Inserting `$_POST`/`$_GET` directly into a query (SQL Injection)
3. Forgetting to close the database connection before finishing the request
4. Storing passwords in plain text instead of using `password_hash()`
5. Printing user input into HTML without sanitizing it (XSS — use `htmlspecialchars()`)
