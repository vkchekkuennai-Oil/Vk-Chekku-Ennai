<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

require_once 'db_config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$input = json_decode(file_get_contents('php://input'), true);

if (!$input) {
    echo json_encode(['success' => false, 'message' => 'Invalid JSON data']);
    exit;
}

// Validate required fields
$required_fields = ['customer_name', 'email', 'contact', 'address', 'city', 'state', 'pincode', 'cart', 'total'];
foreach ($required_fields as $field) {
    if (!isset($input[$field]) || empty($input[$field])) {
        echo json_encode(['success' => false, 'message' => 'Missing required field: ' . $field]);
        exit;
    }
}

// Generate invoice number
$invoice_number = generateInvoiceNumber($conn);

// Start transaction
$conn->begin_transaction();

try {
    // Insert order
    $stmt = $conn->prepare("INSERT INTO orders (invoice_number, customer_name, email, contact, address, city, state, pincode, total_amount, order_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("ssssssssd", $invoice_number, $input['customer_name'], $input['email'], $input['contact'], $input['address'], $input['city'], $input['state'], $input['pincode'], $input['total']);
    $stmt->execute();
    $order_id = $conn->insert_id;
    $stmt->close();

    // Insert order items
    $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_name, quantity, price, total_price) VALUES (?, ?, ?, ?, ?)");
    foreach ($input['cart'] as $item) {
        $quantity = 1; // Default quantity
        $total_price = $item['price'];

        // Check if this product already exists in cart (grouping)
        $existing_items = array_filter($input['cart'], function($cart_item) use ($item) {
            return $cart_item['name'] === $item['name'];
        });

        if (count($existing_items) > 1) {
            // Skip duplicates, they'll be handled by quantity update
            continue;
        }

        // Count actual quantity
        $quantity = count(array_filter($input['cart'], function($cart_item) use ($item) {
            return $cart_item['name'] === $item['name'];
        }));

        $total_price = $item['price'] * $quantity;

        $stmt->bind_param("isidd", $order_id, $item['name'], $quantity, $item['price'], $total_price);
        $stmt->execute();
    }
    $stmt->close();

    // Commit transaction
    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Order placed successfully',
        'invoice_number' => $invoice_number,
        'order_date' => date('d/m/Y h:i A'),
        'order_id' => $order_id
    ]);

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Failed to process order: ' . $e->getMessage()]);
}

$conn->close();

function generateInvoiceNumber($conn) {
    // Get the latest invoice number
    $result = $conn->query("SELECT invoice_number FROM orders ORDER BY id DESC LIMIT 1");

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $last_invoice = $row['invoice_number'];

        // Extract number from VKXX format
        if (preg_match('/VK(\d+)/', $last_invoice, $matches)) {
            $next_number = intval($matches[1]) + 1;
            return 'VK' . str_pad($next_number, 2, '0', STR_PAD_LEFT);
        }
    }

    // First invoice
    return 'VK01';
}
?>