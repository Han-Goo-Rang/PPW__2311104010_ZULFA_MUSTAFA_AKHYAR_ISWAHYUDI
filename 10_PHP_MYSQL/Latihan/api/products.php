<?php
/**
 * Products API
 * Handles CRUD operations for products
 */

require_once 'config.php';
require_once 'auth.php';
require_once 'validators.php';

// Get request method
$method = $_SERVER['REQUEST_METHOD'];

// Route requests based on method
switch ($method) {
    case 'GET':
        handleGet($conn);
        break;
    case 'POST':
        requireAuth();
        handlePost($conn);
        break;
    case 'PUT':
        requireAuth();
        handlePut($conn);
        break;
    case 'DELETE':
        requireAuth();
        handleDelete($conn);
        break;
    default:
        http_response_code(405);
        echo json_encode([
            'success' => false,
            'message' => 'Method not allowed'
        ]);
        break;
}

/**
 * Handle GET requests
 * GET /api/products.php - Get all products
 * GET /api/products.php?id=X - Get single product
 */
function handleGet($conn) {
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;

    if ($id) {
        // Get single product
        getSingleProduct($conn, $id);
    } else {
        // Get all products
        getAllProducts($conn);
    }
}

/**
 * Get all products from database
 */
function getAllProducts($conn) {
    $query = "SELECT id, name, price, description, images, material, accessories, colors, sizes, created_at, updated_at FROM products ORDER BY created_at DESC";
    
    $result = $conn->query($query);
    
    if (!$result) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ]);
        return;
    }

    $products = [];
    while ($row = $result->fetch_assoc()) {
        // Parse JSON images
        $row['images'] = json_decode($row['images'], true) ?? [];
        $products[] = $row;
    }

    echo json_encode([
        'success' => true,
        'data' => $products,
        'count' => count($products)
    ]);
}

/**
 * Get single product by ID
 */
function getSingleProduct($conn, $id) {
    $stmt = $conn->prepare("SELECT id, name, price, description, images, material, accessories, colors, sizes, created_at, updated_at FROM products WHERE id = ?");
    
    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ]);
        return;
    }

    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Product not found'
        ]);
        $stmt->close();
        return;
    }

    $product = $result->fetch_assoc();
    $product['images'] = json_decode($product['images'], true) ?? [];
    $stmt->close();

    echo json_encode([
        'success' => true,
        'data' => $product
    ]);
}

/**
 * Handle POST requests - Create new product
 * POST /api/products.php
 */
function handlePost($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate required fields
    $requiredValidation = validateRequiredFields($input);
    if (!$requiredValidation['valid']) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $requiredValidation['errors']
        ]);
        return;
    }

    // Validate all data
    $dataValidation = validateProductData($input);
    if (!$dataValidation['valid']) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $dataValidation['errors']
        ]);
        return;
    }

    // Prepare data
    $name = trim($input['name']);
    $price = trim($input['price']);
    $description = trim($input['description']);
    $images = isset($input['images']) ? json_encode($input['images']) : json_encode([]);
    $material = isset($input['material']) ? trim($input['material']) : '';
    $accessories = isset($input['accessories']) ? trim($input['accessories']) : '';
    $colors = isset($input['colors']) ? trim($input['colors']) : '';
    $sizes = isset($input['sizes']) ? trim($input['sizes']) : '';

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO products (name, price, description, images, material, accessories, colors, sizes) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ]);
        return;
    }

    $stmt->bind_param("ssssssss", $name, $price, $description, $images, $material, $accessories, $colors, $sizes);
    
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to create product: ' . $stmt->error
        ]);
        $stmt->close();
        return;
    }

    $product_id = $stmt->insert_id;
    $stmt->close();

    // Fetch and return created product
    getSingleProduct($conn, $product_id);
}

/**
 * Handle PUT requests - Update product
 * PUT /api/products.php
 */
function handlePut($conn) {
    $input = json_decode(file_get_contents('php://input'), true);

    // Validate ID
    if (!isset($input['id']) || empty($input['id'])) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Product ID is required'
        ]);
        return;
    }

    $id = intval($input['id']);

    // Check if product exists
    $checkStmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows === 0) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Product not found'
        ]);
        $checkStmt->close();
        return;
    }
    $checkStmt->close();

    // Validate update data
    $dataValidation = validateProductData($input);
    if (!$dataValidation['valid']) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Validation failed',
            'errors' => $dataValidation['errors']
        ]);
        return;
    }

    // Build update query dynamically
    $updates = [];
    $params = [];
    $types = '';

    if (isset($input['name'])) {
        $updates[] = 'name = ?';
        $params[] = trim($input['name']);
        $types .= 's';
    }
    if (isset($input['price'])) {
        $updates[] = 'price = ?';
        $params[] = trim($input['price']);
        $types .= 's';
    }
    if (isset($input['description'])) {
        $updates[] = 'description = ?';
        $params[] = trim($input['description']);
        $types .= 's';
    }
    if (isset($input['images'])) {
        $updates[] = 'images = ?';
        $params[] = json_encode($input['images']);
        $types .= 's';
    }
    if (isset($input['material'])) {
        $updates[] = 'material = ?';
        $params[] = trim($input['material']);
        $types .= 's';
    }
    if (isset($input['accessories'])) {
        $updates[] = 'accessories = ?';
        $params[] = trim($input['accessories']);
        $types .= 's';
    }
    if (isset($input['colors'])) {
        $updates[] = 'colors = ?';
        $params[] = trim($input['colors']);
        $types .= 's';
    }
    if (isset($input['sizes'])) {
        $updates[] = 'sizes = ?';
        $params[] = trim($input['sizes']);
        $types .= 's';
    }

    if (empty($updates)) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'No fields to update'
        ]);
        return;
    }

    // Add ID to params
    $params[] = $id;
    $types .= 'i';

    // Execute update
    $query = "UPDATE products SET " . implode(', ', $updates) . " WHERE id = ?";
    $stmt = $conn->prepare($query);
    
    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ]);
        return;
    }

    $stmt->bind_param($types, ...$params);
    
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to update product: ' . $stmt->error
        ]);
        $stmt->close();
        return;
    }

    $stmt->close();

    // Fetch and return updated product
    getSingleProduct($conn, $id);
}

/**
 * Handle DELETE requests - Delete product
 * DELETE /api/products.php?id=X
 */
function handleDelete($conn) {
    $id = isset($_GET['id']) ? intval($_GET['id']) : null;

    if (!$id) {
        http_response_code(400);
        echo json_encode([
            'success' => false,
            'message' => 'Product ID is required'
        ]);
        return;
    }

    // Check if product exists
    $checkStmt = $conn->prepare("SELECT id FROM products WHERE id = ?");
    $checkStmt->bind_param("i", $id);
    $checkStmt->execute();
    $checkResult = $checkStmt->get_result();
    
    if ($checkResult->num_rows === 0) {
        http_response_code(404);
        echo json_encode([
            'success' => false,
            'message' => 'Product not found'
        ]);
        $checkStmt->close();
        return;
    }
    $checkStmt->close();

    // Delete product
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    
    if (!$stmt) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Database error: ' . $conn->error
        ]);
        return;
    }

    $stmt->bind_param("i", $id);
    
    if (!$stmt->execute()) {
        http_response_code(500);
        echo json_encode([
            'success' => false,
            'message' => 'Failed to delete product: ' . $stmt->error
        ]);
        $stmt->close();
        return;
    }

    $stmt->close();

    echo json_encode([
        'success' => true,
        'message' => 'Product deleted successfully'
    ]);
}
?>
