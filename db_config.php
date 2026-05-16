<?php
// Database configuration for XAMPP (default settings)
// Change these values if you have custom MySQL setup

$servername = "localhost";
$username = "root";     // Default XAMPP username
$password = "";         // Default XAMPP password (empty)
$dbname = "vk_chekku_ennai";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}

// Set charset to utf8
$conn->set_charset("utf8");
?>