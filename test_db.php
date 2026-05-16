<?php
require_once 'db_config.php';

echo "<h1>Database Connection Test</h1>";

if ($conn->connect_error) {
    echo "<p style='color: red;'>Connection failed: " . $conn->connect_error . "</p>";
} else {
    echo "<p style='color: green;'>Database connection successful!</p>";

    // Test if tables exist
    $tables = ['orders', 'order_items', 'admin_users'];
    foreach ($tables as $table) {
        $result = $conn->query("SHOW TABLES LIKE '$table'");
        if ($result->num_rows > 0) {
            echo "<p>✓ Table '$table' exists</p>";
        } else {
            echo "<p style='color: orange;'>⚠ Table '$table' does not exist - run setup_database.php</p>";
        }
    }
}

$conn->close();

echo "<br><a href='index.html'>Back to Website</a>";
?>