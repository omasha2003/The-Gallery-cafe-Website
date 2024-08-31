<?php
include("../Components/db.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents("php://input"), true);
    $order_id = isset($data['order_id']) ? mysqli_real_escape_string($con, $data['order_id']) : '';

    $response = ['success' => false, 'html' => '', 'error' => ''];

    if ($order_id) {
        $query = "SELECT item_title, item_price, item_quantity 
                  FROM order_items 
                  WHERE order_id = '$order_id'";
        $result = mysqli_query($con, $query);

        if ($result) {
            $response['success'] = true;
            $html = "<ul>";
            while ($row = mysqli_fetch_assoc($result)) {
                $html .= "<li>";
                $html .= "<p>Item: " . $row['item_title'] . "</p>";
                $html .= "<p>Price: LKR. " . $row['item_price'] . "</p>";
                $html .= "<p>Quantity: " . $row['item_quantity'] . "</p>";
                $html .= "</li>";
            }
            $html .= "</ul>";
            $response['html'] = $html;
        } else {
            $response['error'] = "Database query error: " . mysqli_error($con);
        }
    } else {
        $response['error'] = "Invalid order ID.";
    }

    mysqli_close($con);
    echo json_encode($response);
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_style.css">
    <style>
    body {
        font-family: 'Lato', sans-serif;
        background-color: #f0f0f0;
        margin: 0;
        padding: 0;
    }

    .container {
        width: 95%;
        margin: 0 auto;
        margin-top: 30px;
    }

    .order-table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
    }

    .order-table th,
    .order-table td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    .order-table th {
        background-color: #405c45;
        color: white;
    }

    .order-table td.actions {
        display: flex;
        align-items: center;
    }

    .order-status-select {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 3px;
        height: 40px;
        max-width: 100%;
        margin-bottom: 15px;
        margin-right: 15px;
        box-sizing: border-box;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        color: #fff;
        background-color: #405c45;
        border: none;
        margin-top: 7px;
        margin-right: -50px;
        border-radius: 5px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s;
        font-size: 16px;
        background-color: #bba586;
    }

    .btn:hover {
        opacity: 70%;
    }

    .order-details {
        display: none;
        background-color: #f9f9f9;
        padding: 20px;
        margin-top: 10px;
        border: 1px solid #ddd;
    }

    .order-details.active {
        display: block;
    }

    .order-details h3 {
        margin-bottom: 10px;
    }

    .order-details p {
        margin: 5px 0;
    }
    </style>
</head>

<body>
    <?php include("../Components/adminnavbar.php"); ?>

    <div class="container">
        <?php
        include("../Components/db.php");

        // Fetch unique orders from customers table
        $query = "SELECT DISTINCT c.id as customer_id, c.customer_name, c.order_number, c.order_date, c.total, c.order_status 
                  FROM order_details c";
        $result = mysqli_query($con, $query);

        if ($result) {
            echo "<table class='order-table'>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Order ID</th>";
            echo "<th>Customer Name</th>";
            echo "<th>Order Number</th>";
            echo "<th>Order Date</th>";
            echo "<th>Total</th>";
            echo "<th>Order Status</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody>";

            while ($row = mysqli_fetch_assoc($result)) {
                // Display customer order details
                echo "<tr class='order-row' data-order-id='" . $row['order_number'] . "'>";
                echo "<td>" . $row['order_number'] . "</td>";
                echo "<td>" . $row['customer_name'] . "</td>";
                echo "<td>" . $row['order_date'] . "</td>";
                echo "<td>LKR " . $row['total'] . "</td>";
                echo "<td>";
                echo "<select class='order-status-select' data-order-id='" . $row['order_number'] . "'>";
                echo "<option value='Placed'" . ($row['order_status'] == 'Placed' ? ' selected' : '') . ">Placed</option>";
                echo "<option value='Processing'" . ($row['order_status'] == 'Processing' ? ' selected' : '') . ">Processing</option>";
                echo "<option value='Packed'" . ($row['order_status'] == 'Packed' ? ' selected' : '') . ">Packed</option>";
                echo "<option value='Delivered'" . ($row['order_status'] == 'Delivered' ? ' selected' : '') . ">Delivered</option>";
                echo "<option value='Served'" . ($row['order_status'] == 'Served' ? ' selected' : '') . ">Served</option>";
                echo "<option value='Cancelled'" . ($row['order_status'] == 'Cancelled' ? ' selected' : '') . ">Cancelled</option>";
                echo "</select>";
                echo "<button class='btn btn-update-status' data-order-id='" . $row['order_number'] . "'>Update</button>";
                echo "</td>";
                echo "</tr>";

                // Placeholder for order details (expandable)
                echo "<tr class='order-details' id='order-details-" . $row['order_number'] . "'>";
                echo "<td colspan='5'>";
                echo "<div class='order-details-content'>";
                echo "<h3>Order Details for Order #" . $row['order_number'] . "</h3>";
                echo "<div class='order-items' data-order-id='" . $row['order_number'] . "'></div>";
                echo "</div>";
                echo "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
        } else {
            echo "Error: " . mysqli_error($con);
        }

        mysqli_close($con);
        ?>
    </div>

    <!-- Custom JS file link -->
    <script src="../js/script.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const orderRows = document.querySelectorAll(".order-row");

        orderRows.forEach(row => {
            row.addEventListener("click", function() {
                const orderId = this.getAttribute('data-order-id');
                const detailsRow = document.querySelector(`#order-details-${orderId}`);
                const detailsContent = detailsRow.querySelector('.order-items');

                // Check if details are already loaded
                if (detailsContent.innerHTML.trim() === "") {
                    // Fetch order items via AJAX
                    fetch(window.location.href, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                            },
                            body: JSON.stringify({
                                order_id: orderId
                            }),
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                detailsContent.innerHTML = data.html;
                            } else {
                                alert('Failed to fetch order details: ' + data.error);
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert(
                                'Failed to fetch order details. See console for more info.'
                            );
                        });
                }

                // Toggle display
                detailsRow.style.display = detailsRow.style.display === 'none' ? 'table-row' :
                    'none';
            });
        });
    });

    document.addEventListener("DOMContentLoaded", function() {
        const statusSelects = document.querySelectorAll(".order-status-select");
        const updateButtons = document.querySelectorAll(".btn-update-status");

        // Event listener for updating order status
        updateButtons.forEach(button => {
            button.addEventListener("click", function() {
                const orderId = this.getAttribute('data-order-id');
                const selectElement = document.querySelector(
                    `.order-status-select[data-order-id='${orderId}']`);
                const newStatus = selectElement.value;

                // Send AJAX request to update status
                fetch('update_order_status.php', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                        },
                        body: JSON.stringify({
                            order_id: orderId,
                            new_status: newStatus
                        }),
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            alert('Order status updated successfully.');
                            // Optionally update UI or handle success
                        } else {
                            alert('Failed to update order status.');
                            console.error(data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Failed to update order status.');
                    });
            });
        });
    });
    </script>
</body>

</html>