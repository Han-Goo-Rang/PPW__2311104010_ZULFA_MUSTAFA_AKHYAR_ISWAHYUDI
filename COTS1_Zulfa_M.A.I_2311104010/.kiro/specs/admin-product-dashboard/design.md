# Design Document - Admin Product Dashboard

## Overview

The Admin Product Dashboard is a backend-integrated system that transforms the static Unwritten fashion website into a dynamic, database-driven application. The system consists of:

1. **Backend API** - PHP-based RESTful API for product CRUD operations
2. **Admin Dashboard** - Web interface for administrators to manage products
3. **Database** - MySQL for persistent product storage
4. **Frontend Integration** - Modified frontend to fetch products from the API

The architecture follows a simple, maintainable approach suitable for a small-scale e-commerce application.

## Architecture

```
┌─────────────────────────────────────────────────────────────┐
│                    Client Layer                              │
├─────────────────────────────────────────────────────────────┤
│  index.html (Customer)  │  admin/dashboard.html (Admin)     │
│  detail.html            │  admin/login.html                 │
└────────────┬────────────────────────────────┬────────────────┘
             │                                │
             └────────────┬───────────────────┘
                          │
                    API Requests (AJAX)
                          │
┌─────────────────────────▼────────────────────────────────────┐
│                    API Layer (PHP)                            │
├─────────────────────────────────────────────────────────────┤
│  api/products.php (GET, POST, PUT, DELETE)                  │
│  api/auth.php (Login, Logout, Session)                      │
│  api/config.php (Database connection)                       │
└────────────┬────────────────────────────────┬────────────────┘
             │                                │
             └────────────┬───────────────────┘
                          │
                    Database Operations
                          │
┌─────────────────────────▼────────────────────────────────────┐
│                  Database Layer (MySQL)                       │
├─────────────────────────────────────────────────────────────┤
│  products table (id, name, price, description, images)      │
│  users table (id, username, password)                       │
└─────────────────────────────────────────────────────────────┘
```

## Components and Interfaces

### Backend Components

#### 1. Database Configuration (api/config.php)

- Establishes SQLite database connection
- Defines database path and initialization
- Provides connection object to other API files

#### 2. Authentication API (api/auth.php)

- Handles user login with username/password validation
- Manages session creation and destruction
- Validates admin credentials against users table
- Returns authentication status and error messages

#### 3. Products API (api/products.php)

- GET /api/products.php - Retrieve all products
- GET /api/products.php?id=X - Retrieve single product
- POST /api/products.php - Create new product
- PUT /api/products.php - Update existing product
- DELETE /api/products.php?id=X - Delete product
- Handles image upload and storage
- Validates input data before database operations

### Frontend Components

#### 1. Admin Dashboard (admin/dashboard.html)

- Product table with CRUD action buttons
- Add Product modal/form
- Edit Product modal/form
- Delete confirmation dialog
- Pagination controls
- Logout button

#### 2. Admin Login (admin/login.html)

- Username and password input fields
- Login button
- Error message display
- Session validation

#### 3. Modified Frontend (index.html, detail.html)

- Fetch products from API instead of hardcoded data
- Display dynamic product information
- Handle API errors gracefully

## Data Models

### Product Model

```
{
  id: integer (primary key),
  name: string (required, max 255),
  price: string (required, format: "Rp X.XXX"),
  description: string (required),
  images: JSON array of image filenames,
  material: string,
  accessories: string,
  colors: string,
  sizes: string,
  created_at: timestamp,
  updated_at: timestamp
}
```

### User Model

```
{
  id: integer (primary key),
  username: string (required, unique),
  password: string (hashed, required),
  created_at: timestamp
}
```

### API Response Format

```
{
  success: boolean,
  message: string,
  data: object or array,
  errors: object (validation errors if any)
}
```

## Correctness Properties

A property is a characteristic or behavior that should hold true across all valid executions of a system—essentially, a formal statement about what the system should do. Properties serve as the bridge between human-readable specifications and machine-verifiable correctness guarantees.

### Property 1: Product Creation Persistence

_For any_ valid product data submitted through the API, creating the product should result in the product being retrievable from the database with identical data.

**Validates: Requirements 2.2, 8.2**

### Property 2: Product Update Consistency

_For any_ existing product and valid update data, updating the product should result in the database containing the new values while preserving the product ID.

**Validates: Requirements 3.2, 8.3**

### Property 3: Product Deletion Completeness

_For any_ product in the database, deleting it should result in the product no longer being retrievable through the API.

**Validates: Requirements 4.2, 8.4**

### Property 4: Authentication Round Trip

_For any_ valid admin credentials, logging in should create a session, and subsequent API requests with that session should be authorized, while logging out should invalidate the session.

**Validates: Requirements 5.2, 5.4**

### Property 5: API Data Consistency

_For any_ product retrieved through the API, the returned data should match the data stored in the database exactly.

**Validates: Requirements 1.2, 7.1**

### Property 6: Frontend-Backend Synchronization

_For any_ product modification in the admin dashboard, the customer-facing pages should reflect the changes without requiring a page refresh.

**Validates: Requirements 6.2, 6.4**

### Property 7: Input Validation Rejection

_For any_ product form submission with missing required fields, the system should reject the submission and return validation error messages without modifying the database.

**Validates: Requirements 2.3, 3.3**

### Property 8: Dashboard Access Control

_For any_ unauthenticated user attempting to access the admin dashboard, the system should redirect to the login page and prevent access to protected resources.

**Validates: Requirements 5.1**

### Property 9: Product List Retrieval Completeness

_For any_ set of products in the database, the GET all products endpoint should return all products with complete and accurate data.

**Validates: Requirements 1.2, 7.1**

### Property 10: Single Product Retrieval Accuracy

_For any_ product ID in the database, the GET single product endpoint should return the correct product with all its data.

**Validates: Requirements 7.2**

### Property 11: Invalid Credentials Rejection

_For any_ invalid username or password combination, the authentication system should reject the login attempt and prevent session creation.

**Validates: Requirements 5.3**

### Property 12: Product Deletion Verification

_For any_ product successfully deleted through the API, subsequent queries for that product should return not found, and the product should not appear in the product list.

**Validates: Requirements 4.2, 4.3**

### Property 13: Update Validation Enforcement

_For any_ product update attempt with invalid data, the system should reject the update and preserve the original product data in the database.

**Validates: Requirements 3.3**

## Error Handling

### API Error Responses

- **400 Bad Request** - Invalid input data or missing required fields
- **401 Unauthorized** - Missing or invalid authentication
- **404 Not Found** - Product or resource does not exist
- **500 Internal Server Error** - Database or server errors

### Frontend Error Handling

- Display user-friendly error messages
- Log errors to browser console for debugging
- Prevent form submission on validation errors
- Show loading states during API requests

### Database Error Handling

- Catch database connection errors
- Validate data before insertion
- Handle concurrent access issues
- Provide meaningful error messages

## Testing Strategy

### Unit Testing

- Test individual API endpoints with various inputs
- Test authentication logic with valid and invalid credentials
- Test input validation for product creation and updates
- Test database operations (CRUD)

### Property-Based Testing

- **Property 1**: Generate random valid product data, create product, verify retrieval
- **Property 2**: Generate random products, update with random valid data, verify changes
- **Property 3**: Generate random products, delete, verify non-retrieval
- **Property 4**: Test login/logout cycles with various credentials
- **Property 5**: Compare API responses with database state
- **Property 6**: Modify products via API, verify frontend reflects changes
- **Property 7**: Generate invalid product data, verify rejection

### Integration Testing

- Test complete CRUD workflows
- Test authentication flow with dashboard access
- Test frontend-backend communication
- Test error scenarios and recovery

### Testing Framework

- **Backend**: PHPUnit for unit and integration tests
- **Frontend**: Jest or Vitest for JavaScript tests
- **API Testing**: Postman or similar for manual API validation

## Implementation Notes

- Use MySQL for database (requires MySQL server setup)
- Implement basic session-based authentication
- Use prepared statements to prevent SQL injection
- Store images in `assets/img/` directory
- Implement CORS headers for API requests
- Use JSON for all API responses
- Implement basic input validation on both frontend and backend
- Use mysqli or PDO for database connection in PHP
