/**
 * API Client
 * Handles all API communication with the backend
 */

const API_BASE_URL = "api";

/**
 * Fetch all products from API
 */
async function fetchAllProducts() {
  try {
    const response = await fetch(`${API_BASE_URL}/products.php`);
    const data = await response.json();

    if (data.success) {
      return data.data;
    } else {
      console.error("Failed to fetch products:", data.message);
      return [];
    }
  } catch (error) {
    console.error("Error fetching products:", error);
    return [];
  }
}

/**
 * Fetch single product by ID
 */
async function fetchProductById(id) {
  try {
    const response = await fetch(`${API_BASE_URL}/products.php?id=${id}`);
    const data = await response.json();

    if (data.success) {
      return data.data;
    } else {
      console.error("Failed to fetch product:", data.message);
      return null;
    }
  } catch (error) {
    console.error("Error fetching product:", error);
    return null;
  }
}

/**
 * Create new product
 */
async function createProduct(productData) {
  try {
    const response = await fetch(`${API_BASE_URL}/products.php`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(productData),
    });

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error creating product:", error);
    return { success: false, message: "Error creating product" };
  }
}

/**
 * Update product
 */
async function updateProduct(productData) {
  try {
    const response = await fetch(`${API_BASE_URL}/products.php`, {
      method: "PUT",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify(productData),
    });

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error updating product:", error);
    return { success: false, message: "Error updating product" };
  }
}

/**
 * Delete product
 */
async function deleteProduct(id) {
  try {
    const response = await fetch(`${API_BASE_URL}/products.php?id=${id}`, {
      method: "DELETE",
    });

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error deleting product:", error);
    return { success: false, message: "Error deleting product" };
  }
}

/**
 * Login user
 */
async function loginUser(username, password) {
  try {
    const response = await fetch(`${API_BASE_URL}/auth.php?action=login`, {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({ username, password }),
    });

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error logging in:", error);
    return { success: false, message: "Error logging in" };
  }
}

/**
 * Logout user
 */
async function logoutUser() {
  try {
    const response = await fetch(`${API_BASE_URL}/auth.php?action=logout`, {
      method: "POST",
    });

    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error logging out:", error);
    return { success: false, message: "Error logging out" };
  }
}

/**
 * Check authentication status
 */
async function checkAuth() {
  try {
    const response = await fetch(`${API_BASE_URL}/auth.php?action=check`);
    const data = await response.json();
    return data;
  } catch (error) {
    console.error("Error checking auth:", error);
    return { authenticated: false };
  }
}
