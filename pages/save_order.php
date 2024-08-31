<?php
session_start();
include("../Components/db.php");

// Function to handle and respond with JSON
function respond($success, $message, $orderId = null) {
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'order_id' => $orderId
    ]);
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    respond(false, 'User not logged in. Please log in to place an order.');
    header("Location: ../Pages/login.php");
}

// Get the JSON data
$orderData = json_decode(file_get_contents('php://input'), true);

if (isset($orderData['order']) && count($orderData['order']) > 0) {
    $orderItems = $orderData['order'];
    $orderId = uniqid(); // Generate a unique order ID

    // Calculate total
    $total = 0;
    foreach ($orderItems as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Insert customer details with order_status = 'Placed'
    $customer_name = $_SESSION['username'];
    $sql_customer = "INSERT INTO order_details (customer_name, order_number, total, order_status)
                     VALUES ('$customer_name', '$orderId', '$total', 'Placed')";
    if (!$con->query($sql_customer)) {
        respond(false, 'Error: ' . $sql_customer . ' ' . $con->error);
    }
    $customer_id = $con->insert_id; // Get the inserted customer ID

    // Save each item in the order to the database
    foreach ($orderItems as $item) {
        $title = $con->real_escape_string($item['title']);
        $price = $con->real_escape_string($item['price']);
        $quantity = $con->real_escape_string($item['quantity']);

        $sql_order = "INSERT INTO order_items (order_id, customer_id, item_title, item_price, item_quantity)
                      VALUES ('$orderId', '$customer_id', '$title', '$price', '$quantity')";

        if (!$con->query($sql_order)) {
            respond(false, 'Error: ' . $sql_order . ' ' . $con->error);
        }
    }

    respond(true, 'Order placed successfully', $orderId);
} else {
    respond(false, 'No items in the order.');
}

$con->close();
?>