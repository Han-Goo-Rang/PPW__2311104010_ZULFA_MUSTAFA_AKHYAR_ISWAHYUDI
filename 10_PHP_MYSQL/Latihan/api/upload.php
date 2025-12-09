<?php
/**
 * Image Upload API
 * Handles image uploads to assets/img directory
 */

require_once 'config.php';
require_once 'auth.php';

// Check authentication
requireAuth();

// Check if file is uploaded
if (!isset($_FILES['file'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'No file uploaded'
    ]);
    exit;
}

$file = $_FILES['file'];
$uploadDir = '../assets/img/';

// Validate file
$allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
$fileExtension = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

if (!in_array($fileExtension, $allowedExtensions)) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'Invalid file type. Allowed: jpg, jpeg, png, gif, webp'
    ]);
    exit;
}

// Check file size (max 5MB)
$maxSize = 5 * 1024 * 1024;
if ($file['size'] > $maxSize) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'message' => 'File size exceeds 5MB limit'
    ]);
    exit;
}

// Generate unique filename
$timestamp = time();
$randomString = bin2hex(random_bytes(4));
$newFilename = 'Art_' . $timestamp . '_' . $randomString . '.' . $fileExtension;
$uploadPath = $uploadDir . $newFilename;

// Create directory if not exists
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0755, true);
}

// Move uploaded file
if (move_uploaded_file($file['tmp_name'], $uploadPath)) {
    echo json_encode([
        'success' => true,
        'message' => 'File uploaded successfully',
        'filename' => $newFilename,
        'path' => 'assets/img/' . $newFilename
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'message' => 'Failed to move uploaded file'
    ]);
}
?>
