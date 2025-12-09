<?php
/**
 * Database Setup & Seeder
 * Run this file once to initialize database and seed test data
 */

require_once 'api/config.php';

echo "<h2>Database Setup & Seeder</h2>";
echo "<hr>";

// Drop existing tables (optional - uncomment if you want fresh start)
// $conn->query("DROP TABLE IF EXISTS users");
// echo "✓ Dropped existing tables<br>";

// Create users table
$sql = "CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "✓ Table 'users' created/exists<br>";
} else {
    echo "✗ Error creating table: " . $conn->error . "<br>";
    exit;
}

// Create products table
$sql = "CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    price VARCHAR(50) NOT NULL,
    description TEXT NOT NULL,
    images JSON,
    material VARCHAR(255),
    accessories VARCHAR(255),
    colors VARCHAR(255),
    sizes VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "✓ Table 'products' created/exists<br>";
} else {
    echo "✗ Error creating products table: " . $conn->error . "<br>";
    exit;
}

// Clear existing users
$conn->query("DELETE FROM users");
echo "✓ Cleared existing users<br>";

// Seed test users with proper password hashing
$users = [
    ['admin', 'admin123', 'admin@unwritten.local'],
    ['user', 'user123', 'user@unwritten.local'],
];

$stmt = $conn->prepare("INSERT INTO users (username, password, email) VALUES (?, ?, ?)");

foreach ($users as $user) {
    $username = $user[0];
    $plainPassword = $user[1];
    $password = password_hash($plainPassword, PASSWORD_BCRYPT, ['cost' => 10]);
    $email = $user[2];
    
    $stmt->bind_param("sss", $username, $password, $email);
    
    if ($stmt->execute()) {
        echo "✓ Created user: <strong>$username</strong> (password: {$plainPassword})<br>";
        echo "  Hash: " . substr($password, 0, 30) . "...<br>";
    } else {
        echo "✗ Error creating user $username: " . $stmt->error . "<br>";
    }
}

$stmt->close();

// Verify users
$result = $conn->query("SELECT id, username, email FROM users");
echo "<br><h3>Users in Database:</h3>";
echo "<table border='1' cellpadding='10'>";
echo "<tr><th>ID</th><th>Username</th><th>Email</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['id']}</td><td>{$row['username']}</td><td>{$row['email']}</td></tr>";
}

echo "</table>";

$conn->close();

echo "<br><hr>";
echo "<h3>Setup Complete!</h3>";
echo "<p><a href='admin/login.html' style='padding: 10px 20px; background: #e75480; color: white; text-decoration: none; border-radius: 5px;'>Go to Login</a></p>";
echo "<p><strong>Test Credentials:</strong></p>";
echo "<ul>";
echo "<li>Username: <strong>admin</strong> | Password: <strong>admin123</strong></li>";
echo "<li>Username: <strong>user</strong> | Password: <strong>user123</strong></li>";
echo "</ul>";
?>
