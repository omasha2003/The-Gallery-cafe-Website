<?php
session_start();
include("../Components/db.php");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $customer_name = mysqli_real_escape_string($con, $_POST['customer_name']);
    $item_name = mysqli_real_escape_string($con, $_POST['item_name']);
    $quantity = mysqli_real_escape_string($con, $_POST['quantity']);
    $order_date = mysqli_real_escape_string($con, $_POST['order_date']);

    // Insert order details into database using prepared statement
    $insert_query = "INSERT INTO orders (customer_name, item_name, quantity, order_date) VALUES (?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $insert_query);
    mysqli_stmt_bind_param($stmt, "ssis", $customer_name, $item_name, $quantity, $order_date);

    if (mysqli_stmt_execute($stmt)) {
        // Order successful, set a session variable and redirect smoothly
        echo "<script>alert('Order added successfully!'); window.location.href='../Pages/admin_dashboard.php';</script>";
        exit();
    } else {
        $errors[] = "Error: " . mysqli_error($con);
    }

    // Display errors
    foreach ($errors as $error) {
        echo "<p>Error: $error</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Order Form</title>
    <style>
        .order-container {
            max-width: 400px;
            margin: 50px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .order-container h2 {
            font-weight: 600;
            margin-bottom: 20px;
            text-align: center;
        }

        .order-container form {
            display: flex;
            flex-direction: column;
        }

        .order-container label {
            margin-bottom: 10px;
        }

        .order-container input, .order-container select {
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 3px;
            font-size: 16px;
        }

        .order-container button {
            background-color: #405c45;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 3px;
            font-size: 16px;
            margin-top: 15px;
        }

        .order-container button:hover {
            background-color: #555;
        }

        .order-container .cancel-button {
            background-color: #282733;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="order-container">
        <h2>Add Order</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="customer_name">Customer Name:</label>
            <input type="text" id="customer_name" name="customer_name" required>

            <label for="item_name">Item Name:</label>
            <input type="text" id="item_name" name="item_name" required>

            <label for="quantity">Quantity:</label>
            <input type="number" id="quantity" name="quantity" required>

            <label for="order_date">Order Date:</label>
            <input type="date" id="order_date" name="order_date" required>

            <button type="submit">Add Order</button>
            <button type="button" class="cancel-button" onclick="window.location.href='../Pages/admin_dashboard.php'">Cancel</button>
        </form>
    </div>

    <?php include("../Components/footer.php"); ?>
</body>
</html>
