<?php
session_start();
include("../Components/db.php");

// Function to handle and respond with JSON
function respond($success, $message) {
    echo json_encode([
        'success' => $success,
        'message' => $message
    ]);
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    respond(false, 'User not logged in. Please log in to update order status.');
}

// Get the JSON data
$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['order_id']) && isset($data['new_status'])) {
    $orderId = $data['order_id'];
    $newStatus = $data['new_status'];

    // Update order status in customers table
    $sql = "UPDATE order_details SET order_status = '$newStatus' WHERE order_number = '$orderId'";
    if ($con->query($sql) === TRUE) {
        respond(true, 'Order status updated successfully.');
    } else {
        respond(false, 'Error updating order status: ' . $con->error);
    }
} else {
    respond(false, 'Invalid request. Missing order ID or new status.');
}

$con->close();
?>