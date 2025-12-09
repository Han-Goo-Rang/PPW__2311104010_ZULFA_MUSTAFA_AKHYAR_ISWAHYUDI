<?php
/**
 * Debug Request
 * Log incoming requests untuk debugging
 */

require_once 'config.php';

// Log request details
$logData = [
    'timestamp' => date('Y-m-d H:i:s'),
    'method' => $_SERVER['REQUEST_METHOD'],
    'url' => $_SERVER['REQUEST_URI'],
    'headers' => getallheaders(),
    'get' => $_GET,
    'post' => $_POST,
    'files' => $_FILES,
    'raw_input' => file_get_contents('php://input')
];

// Log to file
$logFile = '../logs/requests.log';
if (!is_dir('../logs')) {
    mkdir('../logs', 0755, true);
}

file_put_contents($logFile, json_encode($logData, JSON_PRETTY_PRINT) . "\n\n", FILE_APPEND);

echo json_encode([
    'success' => true,
    'message' => 'Request logged',
    'data' => $logData
]);
?>
