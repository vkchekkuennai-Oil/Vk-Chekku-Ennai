<?php
require_once 'db_config.php';

// Create database if it doesn't exist
$conn->query("CREATE DATABASE IF NOT EXISTS vk_chekku_ennai");
$conn->select_db("vk_chekku_ennai");

// Remove legacy tables with old schema if present
$conn->query("DROP TABLE IF EXISTS order_items");
$conn->query("DROP TABLE IF EXISTS invoices");
$conn->query("DROP TABLE IF EXISTS invoice_counter");

// Create orders table
$orders_table = "
CREATE TABLE IF NOT EXISTS orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    invoice_number VARCHAR(10) UNIQUE NOT NULL,
    customer_name VARCHAR(255) NOT NULL,
    email VARCHAR(255) NOT NULL,
    contact VARCHAR(15) NOT NULL,
    address TEXT NOT NULL,
    city VARCHAR(100) NOT NULL,
    state VARCHAR(100) NOT NULL,
    pincode VARCHAR(10) NOT NULL,
    total_amount DECIMAL(10,2) NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($orders_table) === TRUE) {
    echo "Orders table created successfully<br>";
} else {
    echo "Error creating orders table: " . $conn->error . "<br>";
}

// Create order_items table
$order_items_table = "
CREATE TABLE IF NOT EXISTS order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_name VARCHAR(255) NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    total_price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
)";

if ($conn->query($order_items_table) === TRUE) {
    echo "Order items table created successfully<br>";
} else {
    echo "Error creating order items table: " . $conn->error . "<br>";
}

// Create admin_users table (optional, for future expansion)
$admin_table = "
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";

if ($conn->query($admin_table) === TRUE) {
    echo "Admin users table created successfully<br>";
} else {
    echo "Error creating admin users table: " . $conn->error . "<br>";
}

// Insert default admin user (password: admin123 - hash it properly in production)
$hashed_password = password_hash('admin123', PASSWORD_DEFAULT);
$admin_username = 'admin';
$insert_admin = $conn->prepare("INSERT IGNORE INTO admin_users (username, password) VALUES (?, ?)");
$insert_admin->bind_param("ss", $admin_username, $hashed_password);

if ($insert_admin->execute()) {
    echo "Default admin user created (username: admin, password: admin123)<br>";
} else {
    echo "Error creating admin user: " . $conn->error . "<br>";
}
$insert_admin->close();

$conn->close();

echo "<br>Database setup completed! You can now use the application.";
echo "<br><br><a href='index.html'>Go to Website</a> | <a href='admin_login.php'>Admin Login</a>";
?>