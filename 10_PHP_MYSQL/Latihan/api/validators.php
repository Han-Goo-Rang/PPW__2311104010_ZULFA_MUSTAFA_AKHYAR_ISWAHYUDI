<?php
/**
 * Input Validators
 * Provides validation functions for product data
 */

/**
 * Validate product name
 */
function validateProductName($name) {
    $name = trim($name);
    
    if (empty($name)) {
        return ['valid' => false, 'error' => 'Nama produk tidak boleh kosong'];
    }
    
    if (strlen($name) > 255) {
        return ['valid' => false, 'error' => 'Nama produk maksimal 255 karakter'];
    }
    
    return ['valid' => true];
}

/**
 * Validate product price
 */
function validateProductPrice($price) {
    $price = trim($price);
    
    if (empty($price)) {
        return ['valid' => false, 'error' => 'Harga tidak boleh kosong'];
    }
    
    // Check if price format is valid (Rp X.XXX, Rp X,XXX, or just numbers)
    // Remove Rp prefix and spaces
    $cleanPrice = preg_replace('/[^0-9.,]/', '', $price);
    
    if (empty($cleanPrice) || !is_numeric(str_replace(['.', ','], '', $cleanPrice))) {
        return ['valid' => false, 'error' => 'Format harga tidak valid. Gunakan format: Rp 100.000 atau 100000'];
    }
    
    return ['valid' => true];
}

/**
 * Validate product description
 */
function validateProductDescription($description) {
    $description = trim($description);
    
    if (empty($description)) {
        return ['valid' => false, 'error' => 'Deskripsi tidak boleh kosong'];
    }
    
    if (strlen($description) < 10) {
        return ['valid' => false, 'error' => 'Deskripsi minimal 10 karakter'];
    }
    
    return ['valid' => true];
}

/**
 * Validate product images array
 */
function validateProductImages($images) {
    if (!is_array($images)) {
        return ['valid' => false, 'error' => 'Images harus berupa array'];
    }
    
    // Images are optional, but if provided, validate each one
    foreach ($images as $image) {
        if (!is_string($image) || empty(trim($image))) {
            return ['valid' => false, 'error' => 'Setiap nama gambar harus berupa string yang tidak kosong'];
        }
        
        // Check file extension
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
        $file_ext = strtolower(pathinfo($image, PATHINFO_EXTENSION));
        
        if (!in_array($file_ext, $allowed_extensions)) {
            return ['valid' => false, 'error' => 'Format gambar tidak didukung. Gunakan: jpg, jpeg, png, gif, webp'];
        }
    }
    
    return ['valid' => true];
}

/**
 * Validate all product data
 */
function validateProductData($data) {
    $errors = [];
    
    // Validate name
    if (isset($data['name'])) {
        $nameValidation = validateProductName($data['name']);
        if (!$nameValidation['valid']) {
            $errors['name'] = $nameValidation['error'];
        }
    }
    
    // Validate price
    if (isset($data['price'])) {
        $priceValidation = validateProductPrice($data['price']);
        if (!$priceValidation['valid']) {
            $errors['price'] = $priceValidation['error'];
        }
    }
    
    // Validate description
    if (isset($data['description'])) {
        $descValidation = validateProductDescription($data['description']);
        if (!$descValidation['valid']) {
            $errors['description'] = $descValidation['error'];
        }
    }
    
    // Validate images if provided
    if (isset($data['images']) && !empty($data['images'])) {
        $imagesValidation = validateProductImages($data['images']);
        if (!$imagesValidation['valid']) {
            $errors['images'] = $imagesValidation['error'];
        }
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}

/**
 * Validate required fields for creation
 */
function validateRequiredFields($data) {
    $errors = [];
    
    if (!isset($data['name']) || empty(trim($data['name']))) {
        $errors['name'] = 'Nama produk tidak boleh kosong';
    }
    
    if (!isset($data['price']) || empty(trim($data['price']))) {
        $errors['price'] = 'Harga tidak boleh kosong';
    }
    
    if (!isset($data['description']) || empty(trim($data['description']))) {
        $errors['description'] = 'Deskripsi tidak boleh kosong';
    }
    
    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}
?>
