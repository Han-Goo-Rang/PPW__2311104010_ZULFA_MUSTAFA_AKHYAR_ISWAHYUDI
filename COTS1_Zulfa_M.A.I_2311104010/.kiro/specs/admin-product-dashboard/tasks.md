# Implementation Plan - Admin Product Dashboard

- [x] 1. Set up project structure and database configuration


  - Create `api/` directory for backend files
  - Create `admin/` directory for admin interface
  - Create `api/config.php` for MySQL database connection
  - Create database schema with products and users tables
  - _Requirements: 7.1, 8.1_

- [ ] 2. Implement authentication system


  - [ ] 2.1 Create `api/auth.php` for login/logout endpoints

    - Implement POST /api/auth.php?action=login endpoint
    - Implement POST /api/auth.php?action=logout endpoint
    - Validate credentials against users table
    - Create session management
    - _Requirements: 5.2, 5.3, 5.4_


  - [ ] 2.2 Write property test for authentication

    - **Property 4: Authentication Session Validity**

    - **Validates: Requirements 5.2, 5.4**

  - [ ] 2.3 Create `admin/login.html` page
    - Build login form with username and password fields
    - Implement form submission to auth API
    - Display error messages on failed login
    - Redirect to dashboard on successful login
    - _Requirements: 5.1, 5.2, 5.3_


- [ ] 3. Implement products API endpoints

  - [ ] 3.1 Create `api/products.php` with GET endpoint

    - Implement GET /api/products.php to retrieve all products

    - Implement GET /api/products.php?id=X to retrieve single product
    - Return JSON response with product data
    - _Requirements: 7.1, 7.2_


  - [ ] 3.2 Write property test for product retrieval

    - **Property 5: API Data Consistency**
    - **Validates: Requirements 1.2, 7.1**

  - [ ] 3.3 Implement POST endpoint for product creation


    - Handle product form data and image uploads
    - Validate required fields (name, price, description)
    - Insert product into database
    - Return success/error response

    - _Requirements: 2.2, 7.3_

  - [ ] 3.4 Write property test for product creation

    - **Property 1: Product Creation Persistence**
    - **Validates: Requirements 2.2, 8.2**


  - [ ] 3.5 Implement PUT endpoint for product updates

    - Handle product update data
    - Validate update data

    - Update product in database
    - Return success/error response
    - _Requirements: 3.2, 7.4_

  - [ ] 3.6 Write property test for product updates


    - **Property 2: Product Update Consistency**
    - **Validates: Requirements 3.2, 8.3**

  - [ ] 3.7 Implement DELETE endpoint for product deletion


    - Handle product deletion by ID
    - Remove product from database
    - Return success/error response
    - _Requirements: 4.2, 7.5_

  - [ ] 3.8 Write property test for product deletion
    - **Property 3: Product Deletion Completeness**

    - **Validates: Requirements 4.2, 8.4**

- [ ] 4. Implement input validation


  - [ ] 4.1 Add validation for product creation

    - Validate required fields are not empty
    - Validate price format
    - Validate image file types
    - Return validation errors in API response

    - _Requirements: 2.3_

  - [ ] 4.2 Write property test for creation validation

    - **Property 7: Input Validation Rejection**

    - **Validates: Requirements 2.3, 3.3**

  - [ ] 4.3 Add validation for product updates

    - Validate update data before database operation
    - Preserve original data if validation fails
    - Return validation errors in API response
    - _Requirements: 3.3_


  - [ ] 4.4 Write property test for update validation
    - **Property 13: Update Validation Enforcement**
    - **Validates: Requirements 3.3**

- [ ] 5. Create admin dashboard interface

  - [x] 5.1 Create `admin/dashboard.html` page


    - Build product table with ID, name, price, description columns
    - Add product image thumbnails to table
    - Implement edit and delete buttons for each product

    - Add "Add Product" button
    - Implement pagination controls
    - Add logout button
    - _Requirements: 1.1, 1.4_

  - [ ] 5.2 Implement product table loading

    - Fetch products from API on page load

    - Populate table with product data
    - Display pagination based on product count
    - Handle API errors gracefully
    - _Requirements: 1.2, 1.3_

  - [ ] 5.3 Write property test for dashboard access

    - **Property 8: Dashboard Access Control**

    - **Validates: Requirements 5.1**

  - [ ] 5.4 Implement add product modal/form

    - Create form with fields for name, price, description, images
    - Implement form validation on client side

    - Submit form data to POST /api/products.php
    - Display success/error messages
    - Refresh product table after successful creation
    - _Requirements: 2.1, 2.2, 2.4_


  - [ ] 5.5 Implement edit product modal/form

    - Load product data into form when edit button clicked
    - Pre-populate form fields with current product data
    - Submit updates to PUT /api/products.php
    - Display success/error messages
    - Refresh product table after successful update

    - _Requirements: 3.1, 3.2, 3.4_

  - [ ] 5.6 Implement delete confirmation dialog
    - Show confirmation dialog when delete button clicked
    - Submit deletion to DELETE /api/products.php on confirm
    - Display success/error messages

    - Refresh product table after successful deletion
    - _Requirements: 4.1, 4.2, 4.3, 4.4_

- [ ] 6. Checkpoint - Ensure all tests pass


  - Ensure all tests pass, ask the user if questions arise.

- [ ] 7. Update frontend to use API

  - [ ] 7.1 Modify `index.html` to fetch products from API


    - Replace hardcoded products array with API call
    - Fetch products on page load
    - Display products dynamically
    - Handle API errors gracefully
    - _Requirements: 6.1_


  - [ ] 7.2 Modify `detail.html` to fetch product from API

    - Fetch specific product by ID from API
    - Display product data dynamically

    - Handle API errors gracefully
    - _Requirements: 6.3_

  - [ ] 7.3 Write property test for frontend-backend sync
    - **Property 6: Frontend-Backend Synchronization**
    - **Validates: Requirements 6.2, 6.4**


- [ ] 8. Implement session-based access control

  - [ ] 8.1 Add session validation to admin pages

    - Check session on admin page load

    - Redirect to login if not authenticated
    - Validate session on API requests
    - _Requirements: 5.1_

  - [x] 8.2 Add authentication headers to API requests


    - Include session token in API requests
    - Validate token on backend
    - Return 401 if unauthorized
    - _Requirements: 5.1_

- [ ] 9. Checkpoint - Ensure all tests pass

  - Ensure all tests pass, ask the user if questions arise.

- [ ] 10. Integration testing

  - [ ] 10.1 Test complete CRUD workflow

    - Create product, verify in list
    - Update product, verify changes
    - Delete product, verify removal
    - _Requirements: 2.2, 3.2, 4.2_

  - [ ] 10.2 Test authentication flow

    - Login with valid credentials
    - Access dashboard
    - Logout and verify redirect
    - _Requirements: 5.2, 5.4_

  - [ ] 10.3 Test error scenarios
    - Test invalid login attempts
    - Test form validation errors
    - Test API error responses
    - _Requirements: 2.3, 3.3, 5.3_

- [ ] 11. Final Checkpoint - Ensure all tests pass
  - Ensure all tests pass, ask the user if questions arise.
