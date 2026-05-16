<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'db_config.php';

// Get total orders count
$total_orders_result = $conn->query("SELECT COUNT(*) as total FROM orders");
$total_orders = $total_orders_result->fetch_assoc()['total'];

// Get total revenue
$revenue_result = $conn->query("SELECT SUM(total_amount) as revenue FROM orders");
$total_revenue = $revenue_result->fetch_assoc()['revenue'] ?: 0;

// Get today's orders count
$today = date('Y-m-d');
$today_orders_result = $conn->query("SELECT COUNT(*) as today FROM orders WHERE DATE(order_date) = '$today'");
$today_orders = $today_orders_result->fetch_assoc()['today'];

// Get all orders
$orders_result = $conn->query("SELECT * FROM orders ORDER BY order_date DESC");

$orders = [];
while ($row = $orders_result->fetch_assoc()) {
    $orders[] = $row;
}

echo json_encode([
    'success' => true,
    'orders' => $orders,
    'stats' => [
        'total_orders' => $total_orders,
        'total_revenue' => $total_revenue,
        'today_orders' => $today_orders
    ]
]);

$conn->close();
?>