<?php
// 1. Database Configuration
$host = "127.0.0.1";
$user = "root";
$pass = ""; // WAMP default is blank
$db   = "employee_db";
$port = 3307; // Default WAMP MariaDB port. Change to 3306 if needed.

// 2. Create connection
$conn = new mysqli($host, $user, $pass, $db, $port);

// 3. Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 4. Get and Validate form data
// Use null coalescing to prevent "Undefined index" notices
$name       = $_POST['name'] ?? '';
$email      = $_POST['email'] ?? '';
$department = $_POST['department'] ?? '';
$phone      = $_POST['phone'] ?? '';

if (empty($name) || empty($email)) {
    die("Error: Name and Email are required.");
}

// 5. Use Prepared Statements (Security Best Practice)
// This prevents SQL Injection by separating the query from the data
$stmt = $conn->prepare("INSERT INTO employees (name, email, department, phone) VALUES (?, ?, ?, ?)");

// "ssss" means we are sending 4 strings
$stmt->bind_param("ssss", $name, $email, $department, $phone);

// 6. Execute and Check
if ($stmt->execute()) {
    echo "Employee Registered Successfully!";
} else {
    echo "Error: " . $stmt->error;
}

// 7. Close connections
$stmt->close();
$conn->close();
?>