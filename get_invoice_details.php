<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

require_once 'db_config.php';

if (!isset($_GET['invoice_number'])) {
    echo json_encode(['success' => false, 'message' => 'Invoice number is required']);
    exit;
}

$invoice_number = $_GET['invoice_number'];

// Get invoice details
$stmt = $conn->prepare("SELECT * FROM orders WHERE invoice_number = ?");
$stmt->bind_param("s", $invoice_number);
$stmt->execute();
$invoice_result = $stmt->get_result();

if ($invoice_result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Invoice not found']);
    exit;
}

$invoice = $invoice_result->fetch_assoc();
$stmt->close();

// Get order items
$stmt = $conn->prepare("SELECT * FROM order_items WHERE order_id = ?");
$stmt->bind_param("i", $invoice['id']);
$stmt->execute();
$items_result = $stmt->get_result();

$items = [];
while ($row = $items_result->fetch_assoc()) {
    $items[] = $row;
}
$stmt->close();

echo json_encode([
    'success' => true,
    'invoice' => $invoice,
    'items' => $items
]);

$conn->close();
?>