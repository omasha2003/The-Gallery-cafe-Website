<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
session_start();
include("../Components/db.php");

$errors = []; // Initialize errors array

// Ensure the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$username = $_SESSION['username'];

// Retrieve the user's telephone number from the database
$query = "SELECT phonenumber FROM userdetails WHERE username = ?";
$stmt = mysqli_prepare($con, $query);
if (!$stmt) {
    $errors[] = "Error preparing statement: " . mysqli_error($con);
} else {
    mysqli_stmt_bind_param($stmt, "s", $username);
    if (!mysqli_stmt_execute($stmt)) {
        $errors[] = "Error executing statement: " . mysqli_stmt_error($stmt);
    } else {
        $result = mysqli_stmt_get_result($stmt);
        if ($result && mysqli_num_rows($result) > 0) {
            $user_data = mysqli_fetch_assoc($result);
            $telephone_number = $user_data['phonenumber'];
        } else {
            $errors[] = "Error retrieving user information or user not found.";
        }
    }
    mysqli_stmt_close($stmt); // Ensure this is called only once
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $table = mysqli_real_escape_string($con, $_POST['table']);
    $date = mysqli_real_escape_string($con, $_POST['date']);
    $meal = mysqli_real_escape_string($con, $_POST['meal']);

    // Check if the reservation already exists
    $query = "SELECT * FROM reservations WHERE table_choice = ? AND date = ? AND meal = ?";
    $stmt = mysqli_prepare($con, $query);
    if (!$stmt) {
        $errors[] = "Error preparing statement: " . mysqli_error($con);
    } else {
        mysqli_stmt_bind_param($stmt, "sss", $table, $date, $meal);
        if (!mysqli_stmt_execute($stmt)) {
            $errors[] = "Error executing statement: " . mysqli_stmt_error($stmt);
        } else {
            $result = mysqli_stmt_get_result($stmt);
            if ($result && mysqli_num_rows($result) > 0) {
                $_SESSION['error_message'] = "A reservation already exists for the selected table, date, and meal.";
            } else {
                // Insert reservation data into database
                $query = "INSERT INTO reservations (username, phonenumber, date, meal, table_choice, reservation_status) VALUES (?, ?, ?, ?, ?, 'requested')";
                $stmt = mysqli_prepare($con, $query);
                if (!$stmt) {
                    $errors[] = "Error preparing statement: " . mysqli_error($con);
                } else {
                    mysqli_stmt_bind_param($stmt, "sssss", $username, $telephone_number, $date, $meal, $table);
                    if (!mysqli_stmt_execute($stmt)) {
                        $errors[] = "Error executing statement: " . mysqli_stmt_error($stmt);
                    } else {
                        $_SESSION['success_message'] = "Reservation request submitted successfully!";
                    }
                    mysqli_stmt_close($stmt); 
                }
            }
        }
        mysqli_stmt_close($stmt); 
    }
}

mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve a Table - The Gallery Café</title>
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
</head>

<style>
.reservation-container {
    max-width: 400px;
    margin: 50px auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 100px;
}

.reservation-container h2 {
    font-weight: 600;
    margin-bottom: 20px;
    text-align: center;
}

.reservation-container form {
    display: flex;
    flex-direction: column;
}

.reservation-container label {
    margin-bottom: 10px;
}

.reservation-container input,
.reservation-container select {
    padding: 10px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 3px;
    font-size: 16px;
}

.reservation-container button {
    background-color: #405c45;
    color: #fff;
    border: none;
    padding: 10px 20px;
    cursor: pointer;
    border-radius: 3px;
    font-size: 16px;
    margin-top: 15px;
}

.reservation-container button:hover {
    background-color: #555;
}

.error-messages p {
    color: red;
}
</style>

<body>
    <?php include("../Components/navigationbar.php"); ?>

    <div class="reservation-container">
        <h2>Reserve a Table</h2>
        <?php if (!empty($errors)) : ?>
        <div class="error-messages">
            <?php foreach ($errors as $error) : ?>
            <p><?php echo htmlspecialchars($error); ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="table">Choose Table:</label>
            <select id="table" name="table" required>
                <option value="Duos_Delight">Duos Delight</option>
                <option value="table_2">Table 2</option>
                <option value="table_3">Table 3</option>
                <option value="table_4">Table 4</option>
                <option value="table_5">Table 5</option>
                <option value="Rooftop_Special_table">Rooftop Special Table</option>
            </select>

            <label for="date">Select Date:</label>
            <input type="text" id="datepicker" name="date" required>

            <label for="meal">Choose Meal:</label>
            <select id="meal" name="meal" required>
                <option value="breakfast">Breakfast</option>
                <option value="lunch">Lunch</option>
                <option value="dinner">Dinner</option>
            </select>

            <button type="submit">Reserve</button>
            <button type="button" onclick="window.location.href='reservation.php';" style="background-color:#ccc; color:#555">Go Back</button>
        </form>
    </div>

    <?php include("../Components/footer.php"); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script>
    flatpickr("#datepicker", {
        dateFormat: "Y-m-d",
        minDate: new Date().fp_incr(1) // Minimum date is tomorrow
    });

    // Show success or error message if it exists
    document.addEventListener('DOMContentLoaded', function() {
        <?php if (isset($_SESSION['success_message'])): ?>
        alert("<?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>");
        window.location.href = 'reservation.php'; // Redirect after alert is closed
        <?php elseif (isset($_SESSION['error_message'])): ?>
        alert("<?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>");
        <?php endif; ?>
    });
    </script>
</body>

</html>
