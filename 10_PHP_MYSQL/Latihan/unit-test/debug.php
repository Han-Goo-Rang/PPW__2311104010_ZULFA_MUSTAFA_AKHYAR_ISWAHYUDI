<?php
require_once 'api/config.php';

echo "<h2>Debug Information</h2>";
echo "<hr>";

// Check database connection
echo "<h3>Database Connection</h3>";
if ($conn->connect_error) {
    echo "✗ Connection failed: " . $conn->connect_error;
} else {
    echo "✓ Connected to database: " . DB_NAME;
}
echo "<br><br>";

// Check users table
echo "<h3>Users Table</h3>";
$result = $conn->query("SELECT * FROM users");
if (!$result) {
    echo "✗ Error: " . $conn->error;
} else {
    echo "✓ Table exists. Total users: " . $result->num_rows . "<br><br>";
    
    if ($result->num_rows > 0) {
        echo "<table border='1' cellpadding='10'>";
        echo "<tr><th>ID</th><th>Username</th><th>Email</th><th>Password Hash</th></tr>";
        
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>" . $row['id'] . "</td>";
            echo "<td>" . $row['username'] . "</td>";
            echo "<td>" . $row['email'] . "</td>";
            echo "<td><small>" . substr($row['password'], 0, 20) . "...</small></td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "✗ No users found in database!";
    }
}
echo "<br><br>";

// Test password verification
echo "<h3>Password Verification Test</h3>";
$stmt = $conn->prepare("SELECT password FROM users WHERE username = ?");
$username = 'admin';
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $hash = $row['password'];
    
    echo "Testing password 'admin123' against hash:<br>";
    echo "Hash: " . $hash . "<br>";
    
    if (password_verify('admin123', $hash)) {
        echo "✓ Password verification SUCCESS";
    } else {
        echo "✗ Password verification FAILED";
    }
} else {
    echo "✗ User 'admin' not found";
}

$stmt->close();
$conn->close();
?>
