# Developer Guide - Unwritten Project

## 📚 Daftar Isi

1. [Setup Development Environment](#setup-development-environment)
2. [Project Structure](#project-structure)
3. [Code Standards](#code-standards)
4. [API Development](#api-development)
5. [Frontend Development](#frontend-development)
6. [Database Management](#database-management)
7. [Testing & Debugging](#testing--debugging)
8. [Deployment](#deployment)

---

## 🛠️ Setup Development Environment

### Requirements

- PHP 7.4 atau lebih tinggi
- MySQL 5.7 atau lebih tinggi
- Apache (Laragon recommended)
- Git (optional)
- Code Editor (VS Code recommended)

### Installation Steps

#### 1. Clone/Download Project

```bash
# Jika menggunakan git
git clone <repository-url> 10_PHP_MYSQL
cd 10_PHP_MYSQL

# Atau download manual ke C:\laragon\www\10_PHP_MYSQL
```

#### 2. Setup Database

```bash
# Akses browser
http://localhost/10_PHP_MYSQL/database-setup.php

# Atau manual via phpMyAdmin
# 1. Create database: unwritten_db
# 2. Import schema dari database-setup.php
```

#### 3. Verify Installation

```bash
# Akses debug page
http://localhost/10_PHP_MYSQL/debug.php

# Pastikan semua ✅ (connected, tables exist, password verified)
```

#### 4. Start Development

```bash
# Buka di browser
http://localhost/10_PHP_MYSQL/index.html
```

---

## 📁 Project Structure

### Folder Organization

```
10_PHP_MYSQL/
│
├── 📄 index.html                    # Homepage (public)
├── 📄 detail.html                   # Product detail page
├── 📄 database-setup.php            # Database initialization
├── 📄 debug.php                     # Debug utilities
├── 📄 DOKUMENTASI.md                # User documentation
├── 📄 DEVELOPER_GUIDE.md            # This file
│
├── 📁 admin/                        # Admin panel
│   ├── login.html                   # Login page
│   ├── dashboard.html               # Admin dashboard
│   └── .htaccess                    # Access control
│
├── 📁 api/                          # Backend API
│   ├── auth.php                     # Authentication (login/logout/check)
│   ├── products.php                 # Product CRUD operations
│   ├── upload.php                   # File upload handler
│   ├── config.php                   # Database & session config
│   ├── validators.php               # Input validation functions
│   └── .htaccess                    # API access control
│
├── 📁 assets/                       # Frontend assets
│   ├── app.css                      # Main stylesheet
│   ├── script.js                    # Main JavaScript
│   ├── api-client.js                # API client wrapper
│   └── 📁 img/                      # Product images
│       ├── Art1.jpeg
│       ├── Art2.jpeg
│       ├── Banner.jpg
│       └── ...
│
└── 📁 logs/                         # Application logs (auto-created)
    └── requests.log                 # Request logs
```

### File Responsibilities

| File                   | Purpose        | Responsibility                    |
| ---------------------- | -------------- | --------------------------------- |
| `index.html`           | Homepage       | Frontend - Product catalog        |
| `detail.html`          | Product detail | Frontend - Single product view    |
| `admin/login.html`     | Admin login    | Frontend - Authentication UI      |
| `admin/dashboard.html` | Admin panel    | Frontend - Product management     |
| `api/auth.php`         | Authentication | Backend - User login/logout       |
| `api/products.php`     | Product CRUD   | Backend - Product operations      |
| `api/upload.php`       | File upload    | Backend - Image upload            |
| `api/config.php`       | Configuration  | Backend - DB connection & session |
| `api/validators.php`   | Validation     | Backend - Input validation        |
| `assets/script.js`     | Main logic     | Frontend - Page logic             |
| `assets/api-client.js` | API wrapper    | Frontend - API communication      |

---

## 📋 Code Standards

### PHP Standards

#### Naming Conventions

```php
// Functions: camelCase
function handleLogin($conn) { }
function validateProductName($name) { }

// Variables: camelCase
$userName = "admin";
$productId = 1;

// Constants: UPPER_SNAKE_CASE
define('DB_HOST', 'localhost');
define('MAX_FILE_SIZE', 5242880);

// Classes: PascalCase (if used)
class ProductValidator { }
```

#### Code Style

```php
// Indentation: 4 spaces
if ($condition) {
    // Code here
}

// Braces: Opening on same line
function myFunction() {
    // Code
}

// Comments: Use /** */ for functions
/**
 * Handle user login
 * @param mysqli $conn Database connection
 * @return void
 */
function handleLogin($conn) {
    // Implementation
}
```

#### Security Best Practices

```php
// ✅ GOOD: Use prepared statements
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();

// ❌ BAD: String concatenation (SQL injection risk)
$query = "SELECT * FROM users WHERE username = '$username'";

// ✅ GOOD: Hash passwords
$hash = password_hash($password, PASSWORD_BCRYPT);

// ❌ BAD: Plain text passwords
$password = $_POST['password'];

// ✅ GOOD: Validate input
if (empty(trim($input))) {
    return ['valid' => false, 'error' => 'Input required'];
}

// ✅ GOOD: Check authentication
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    http_response_code(401);
    exit();
}
```

### JavaScript Standards

#### Naming Conventions

```javascript
// Functions: camelCase
function handleLogin() {}
function fetchAllProducts() {}

// Variables: camelCase
let userName = "admin";
const MAX_RETRIES = 3;

// Classes: PascalCase
class ProductManager {}

// Constants: UPPER_SNAKE_CASE
const API_BASE_URL = "api";
```

#### Code Style

```javascript
// Use const by default, let if needed, avoid var
const API_URL = "api/products.php";
let currentPage = 1;

// Arrow functions for callbacks
products.forEach((product) => {
  console.log(product.name);
});

// Template literals for strings
const message = `Product ${name} added successfully`;

// Async/await for promises
async function loadProducts() {
  const products = await fetchAllProducts();
  return products;
}
```

#### Error Handling

```javascript
// ✅ GOOD: Try-catch with meaningful errors
try {
  const response = await fetch(url);
  const data = await response.json();
  return data;
} catch (error) {
  console.error("Error fetching products:", error);
  return [];
}

// ✅ GOOD: Check response status
if (!response.ok) {
  throw new Error(`HTTP error! status: ${response.status}`);
}

// ✅ GOOD: Validate data
if (!data || !Array.isArray(data)) {
  console.error("Invalid data format");
  return [];
}
```

### HTML/CSS Standards

#### HTML

```html
<!-- Use semantic HTML -->
<header>...</header>
<nav>...</nav>
<main>...</main>
<footer>...</footer>

<!-- Use meaningful IDs and classes -->
<div id="productList" class="product-grid">...</div>

<!-- Use data attributes for JS hooks -->
<button data-product-id="1" class="add-to-cart">Add</button>
```

#### CSS

```css
/* Use BEM naming convention */
.product-card {
}
.product-card__image {
}
.product-card__title {
}
.product-card--featured {
}

/* Use CSS variables for colors */
:root {
  --color-primary: #e75480;
  --color-secondary: #667eea;
}

.btn-primary {
  background-color: var(--color-primary);
}
```

---

## 🔌 API Development

### Creating New Endpoints

#### Step 1: Create API File

```php
<?php
// api/new-feature.php

require_once 'config.php';
require_once 'auth.php';

$method = $_SERVER['REQUEST_METHOD'];

switch ($method) {
    case 'GET':
        handleGet();
        break;
    case 'POST':
        requireAuth();  // Require authentication
        handlePost();
        break;
    default:
        http_response_code(405);
        echo json_encode(['success' => false, 'message' => 'Method not allowed']);
}

function handleGet() {
    // Implementation
}

function handlePost() {
    // Implementation
}
?>
```

#### Step 2: Add Validation

```php
// In validators.php
function validateNewFeature($data) {
    $errors = [];

    if (!isset($data['field']) || empty(trim($data['field']))) {
        $errors['field'] = 'Field is required';
    }

    return [
        'valid' => empty($errors),
        'errors' => $errors
    ];
}
```

#### Step 3: Call from Frontend

```javascript
// In assets/api-client.js
async function callNewFeature(data) {
  try {
    const response = await fetch("api/new-feature.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });
    return await response.json();
  } catch (error) {
    console.error("Error:", error);
    return { success: false };
  }
}
```

### Response Format

#### Success Response

```json
{
  "success": true,
  "message": "Operation successful",
  "data": {
    "id": 1,
    "name": "Product Name"
  }
}
```

#### Error Response

```json
{
  "success": false,
  "message": "Validation failed",
  "errors": {
    "field1": "Error message",
    "field2": "Error message"
  }
}
```

### HTTP Status Codes

| Code | Usage                          |
| ---- | ------------------------------ |
| 200  | Success                        |
| 201  | Created                        |
| 400  | Bad Request (validation error) |
| 401  | Unauthorized (not logged in)   |
| 403  | Forbidden (no permission)      |
| 404  | Not Found                      |
| 405  | Method Not Allowed             |
| 500  | Server Error                   |

---

## 🎨 Frontend Development

### Adding New Pages

#### Step 1: Create HTML File

```html
<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Page Title</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet" />
    <link rel="stylesheet" href="assets/app.css" />
  </head>
  <body>
    <!-- Content -->

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/api-client.js"></script>
    <script src="assets/script.js"></script>
  </body>
</html>
```

#### Step 2: Add Page Logic

```javascript
// In assets/script.js
if (window.location.pathname.includes("new-page.html")) {
  loadNewPageData();
}

async function loadNewPageData() {
  const data = await fetchNewPageData();
  renderNewPage(data);
}

function renderNewPage(data) {
  // Update DOM with data
}
```

### Working with Forms

#### Form Validation

```javascript
function validateForm(formData) {
  const errors = {};

  if (!formData.name || formData.name.trim() === "") {
    errors.name = "Name is required";
  }

  if (!formData.email || !isValidEmail(formData.email)) {
    errors.email = "Valid email is required";
  }

  return {
    valid: Object.keys(errors).length === 0,
    errors: errors,
  };
}

function isValidEmail(email) {
  return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}
```

#### Form Submission

```javascript
$("#myForm").on("submit", function (e) {
  e.preventDefault();

  const formData = {
    name: $("#name").val(),
    email: $("#email").val(),
  };

  const validation = validateForm(formData);
  if (!validation.valid) {
    displayErrors(validation.errors);
    return;
  }

  submitForm(formData);
});

async function submitForm(data) {
  try {
    const response = await fetch("api/endpoint.php", {
      method: "POST",
      headers: { "Content-Type": "application/json" },
      body: JSON.stringify(data),
    });

    const result = await response.json();

    if (result.success) {
      showSuccess("Form submitted successfully");
      // Redirect or refresh
    } else {
      showError(result.message);
    }
  } catch (error) {
    showError("An error occurred");
  }
}
```

---

## 💾 Database Management

### Adding New Tables

```php
// In database-setup.php
$sql = "CREATE TABLE IF NOT EXISTS new_table (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)";

if ($conn->query($sql) === TRUE) {
    echo "✓ Table created successfully<br>";
} else {
    echo "✗ Error creating table: " . $conn->error . "<br>";
}
```

### Database Queries

#### SELECT

```php
// Get all records
$result = $conn->query("SELECT * FROM products");
while ($row = $result->fetch_assoc()) {
    // Process row
}

// Get single record with prepared statement
$stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$product = $result->fetch_assoc();
```

#### INSERT

```php
$stmt = $conn->prepare("INSERT INTO products (name, price) VALUES (?, ?)");
$stmt->bind_param("ss", $name, $price);
if ($stmt->execute()) {
    $id = $stmt->insert_id;
}
```

#### UPDATE

```php
$stmt = $conn->prepare("UPDATE products SET name = ?, price = ? WHERE id = ?");
$stmt->bind_param("ssi", $name, $price, $id);
$stmt->execute();
```

#### DELETE

```php
$stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
```

---

## 🧪 Testing & Debugging

### Browser DevTools

#### Console

```javascript
// Check for errors
console.log("Debug message");
console.error("Error message");
console.warn("Warning message");

// Test API calls
fetch("api/products.php")
  .then((r) => r.json())
  .then((d) => console.log(d));
```

#### Network Tab

1. Open DevTools (F12)
2. Go to Network tab
3. Perform action
4. Check request/response
5. Verify status code and response data

#### Elements Tab

1. Inspect HTML structure
2. Check CSS styles
3. Modify DOM for testing
4. Check computed styles

### PHP Debugging

#### Error Logging

```php
// Log to file
error_log('Debug message', 3, '../logs/debug.log');

// Log to console
error_log('Debug message');

// Check logs
tail -f /path/to/error.log
```

#### Debug Output

```php
// Print and die
var_dump($data);
die();

// Pretty print
echo '<pre>';
print_r($data);
echo '</pre>';
```

### Testing Checklist

- [ ] Database connection works
- [ ] Login/logout works
- [ ] CRUD operations work
- [ ] Form validation works
- [ ] Error handling works
- [ ] Responsive design works
- [ ] API responses are correct
- [ ] Session management works
- [ ] File upload works
- [ ] Search/filter works

---

## 🚀 Deployment

### Pre-Deployment Checklist

- [ ] All features tested locally
- [ ] No console errors
- [ ] Database backup created
- [ ] Environment variables configured
- [ ] Security headers added
- [ ] HTTPS enabled
- [ ] Error logging configured
- [ ] Performance optimized

### Deployment Steps

#### 1. Prepare Server

```bash
# SSH into server
ssh user@server.com

# Navigate to web root
cd /var/www/html

# Clone project
git clone <repository-url> unwritten
cd unwritten
```

#### 2. Setup Environment

```bash
# Create .env file
cp .env.example .env

# Update database credentials
nano .env

# Set permissions
chmod 755 assets/img
chmod 755 logs
```

#### 3. Setup Database

```bash
# Import database
mysql -u user -p database_name < database.sql

# Or run setup script
php database-setup.php
```

#### 4. Configure Web Server

```apache
# .htaccess for Apache
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /unwritten/

    # Redirect to index.html
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.html [L]
</IfModule>
```

#### 5. Enable HTTPS

```bash
# Using Let's Encrypt
certbot certonly --apache -d yourdomain.com

# Update .htaccess to force HTTPS
RewriteCond %{HTTPS} off
RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
```

### Post-Deployment

- [ ] Test all features on production
- [ ] Monitor error logs
- [ ] Setup automated backups
- [ ] Configure monitoring/alerts
- [ ] Document deployment process

---

## 📞 Support & Resources

### Useful Links

- [PHP Documentation](https://www.php.net/docs.php)
- [MySQL Documentation](https://dev.mysql.com/doc/)
- [Bootstrap Documentation](https://getbootstrap.com/docs/)
- [MDN Web Docs](https://developer.mozilla.org/)

### Common Issues

**Issue:** CORS error
**Solution:** Check `Access-Control-Allow-Origin` header in config.php

**Issue:** Session not persisting
**Solution:** Ensure `session_start()` is called before any output

**Issue:** File upload fails
**Solution:** Check folder permissions and file size limits

---

**Last Updated:** December 2025
**Version:** 1.0.0
**Maintained By:** Development Team
