<?php
require_once 'api/config.php';

echo "<h2>Database Setup</h2>";

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "✓ Table users created/exists<br>";
} else {
    echo "✗ Error creating table: " . $conn->error . "<br>";
}

// Check if admin user exists
$stmt = $conn->prepare("SELECT id FROM users WHERE username = ?");
$username = 'admin';
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    echo "✓ Admin user already exists<br>";
} else {
    // Insert test user (username: admin, password: admin123)
    $password = password_hash('admin123', PASSWORD_BCRYPT);
    $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
    $stmt->bind_param("ss", $username, $password);
    
    if ($stmt->execute()) {
        echo "✓ Admin user created (username: admin, password: admin123)<br>";
    } else {
        echo "✗ Error creating user: " . $stmt->error . "<br>";
    }
}

$stmt->close();
$conn->close();

echo "<br><a href='admin/login.html'>Go to Login</a>";
?>
