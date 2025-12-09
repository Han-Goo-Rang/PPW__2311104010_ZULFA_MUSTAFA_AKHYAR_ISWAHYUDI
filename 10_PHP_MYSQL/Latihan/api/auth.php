<?php
/**
 * Authentication API
 * Handles user login, logout, and session management
 */

require_once 'config.php';

// Only handle requests if this file is accessed directly
if (basename($_SERVER['PHP_SELF']) === 'auth.php') {
    // Get request method and action
    $method = $_SERVER['REQUEST_METHOD'];
    $action = isset($_GET['action']) ? $_GET['action'] : '';

    // Handle different actions
    switch ($action) {
        case 'login':
            handleLogin($conn);
            break;
        case 'logout':
            handleLogout();
            break;
        case 'check':
            checkSession();
            break;
        default:
            http_response_code(400);
            echo json_encode([
                'success' => false,
                'message' => 'Invalid action'
            ]);
            break;
    }
}

/**
 * Handle user login
 * POST /api/auth.php?action=login
 */
function handleLogin($conn) {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        return;
    }

    // Get JSON input
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Validate input
    if (!isset($input['username']) || !isset($input['password'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Username and password are required',
            'errors' => [
                'username' => !isset($input['username']) ? 'Username is required' : '',
                'password' => !isset($input['password']) ? 'Password is required' : ''
            ]
        ]);
        return;
    }

    $username = trim($input['username']);
    $password = trim($input['password']);

    // Validate credentials
    if (empty($username) || empty($password)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Username and password cannot be empty',
            'errors' => [
                'username' => empty($username) ? 'Username cannot be empty' : '',
                'password' => empty($password) ? 'Password cannot be empty' : ''
            ]
        ]);
        return;
    }

    // Query user from database
    $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ]);
        return;
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid username or password'
        ]);
        $stmt->close();
        return;
    }

    $user = $result->fetch_assoc();
    $stmt->close();

    // Verify password
    if (!password_verify($password, $user['password'])) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Invalid username or password'
        ]);
        return;
    }

    // Create session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['username'] = $user['username'];
    $_SESSION['logged_in'] = true;

    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'data' => [
            'user_id' => $user['id'],
            'username' => $user['username']
        ]
    ]);
}

/**
 * Handle user logout
 * POST /api/auth.php?action=logout
 */
function handleLogout() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        return;
    }

    // Destroy session
    session_destroy();

    echo json_encode([
        'success' => true,
        'message' => 'Logout successful'
    ]);
}

/**
 * Check if user is authenticated
 * GET /api/auth.php?action=check
 */
function checkSession() {
    // Debug: log session status
    error_log('Session ID: ' . session_id());
    error_log('Session data: ' . json_encode($_SESSION));
    
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
        echo json_encode([
            'success' => true,
            'authenticated' => true,
            'data' => [
                'user_id' => $_SESSION['user_id'],
                'username' => $_SESSION['username']
            ]
        ]);
    } else {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'authenticated' => false,
            'message' => 'Not authenticated',
            'debug' => [
                'session_id' => session_id(),
                'session_status' => session_status(),
                'session_data' => $_SESSION
            ]
        ]);
    }
}

/**
 * Middleware to check authentication
 * Call this function at the start of protected endpoints
 */
function requireAuth() {
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        http_response_code(401);
        echo json_encode([
            'success' => false,
            'message' => 'Unauthorized: Please login first'
        ]);
        exit();
    }
}
?>
