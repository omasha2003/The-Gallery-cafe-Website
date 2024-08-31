<?php
session_start();
include("../Components/db.php");

$errors = []; // Initialize errors array

// Check if user ID is provided and valid
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $food_id = intval($_GET['id']);

    // Check if food ID is valid
    if ($food_id > 0) {
        // Retrieve food details from the database
        $query = "SELECT * FROM menu WHERE id = ?";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "i", $food_id);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch food data
            $food_data = mysqli_fetch_assoc($result);
        } else {
            // No food found with the provided ID
            echo "No food item found with ID $food_id";
            exit();
        }
    } else {
        // Invalid food ID (ID is 0 or not provided)
        echo "Invalid food ID $food_id";
        exit();
    }
} else {
    // No food ID provided in the URL
    echo "Food ID not specified.";
    exit();
}

// Handle form submission for both update and add new food item
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $name = mysqli_real_escape_string($con, $_POST['name']);
    $description = mysqli_real_escape_string($con, $_POST['description']);
    $price = mysqli_real_escape_string($con, $_POST['price']);
    $category = mysqli_real_escape_string($con, $_POST['category']);
    $image_path = '';

    // Handle image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $target_dir = "../uploads/";
        $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
        $target_file = $target_dir . basename($_FILES['image']['name']);
        $uploadOk = 1;

        // Check file size
        if ($_FILES['image']['size'] > 5000000) {
            $errors[] = "Sorry, your file is too large.";
            $uploadOk = 0;
        }

        // Allow certain file formats
        $allowed_formats = array("jpg", "jpeg", "png", "gif");
        if (!in_array($imageFileType, $allowed_formats)) {
            $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
        }

        // If upload is okay, move the file
        if ($uploadOk) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                $image_path = $target_file;
            } else {
                $errors[] = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Update or insert data into database
    if (empty($errors)) {
        if (!empty($image_path)) {
            // Update existing food item
            $update_query = "UPDATE menu SET name = ?, description = ?, price = ?, category = ?, image = ? WHERE id = ?";
            $stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($stmt, "ssdssi", $name, $description, $price, $category, $image_path, $food_id);
        } else {
            // Update without changing image path
            $update_query = "UPDATE menu SET name = ?, description = ?, price = ?, category = ? WHERE id = ?";
            $stmt = mysqli_prepare($con, $update_query);
            mysqli_stmt_bind_param($stmt, "ssdsi", $name, $description, $price, $category, $food_id);
        }

        if (mysqli_stmt_execute($stmt)) {
            $_SESSION['success_message'] = "Food item updated successfully!";
            header("Location: ../Pages/adminfoodmenu.php");
            exit();
        } else {
            $errors[] = "Error updating food item: " . mysqli_error($con);
        }
    }
}
mysqli_close($con);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Food Item</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap">
    <style>
    body {
        font-family: 'Lato', sans-serif;
        background-color: #f0f0f0;
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        margin: 0;
    }

    .edit-food-container {
        width: 400px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
    }

    .edit-food-container h2 {
        font-weight: 600;
        margin-bottom: 20px;
        text-align: center;
        color: #405c45;
    }

    .edit-food-container form {
        display: flex;
        flex-direction: column;
    }

    .edit-food-container label {
        margin-bottom: 10px;
        color: #405c45;
    }

    .edit-food-container input,
    .edit-food-container textarea {
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 16px;
    }

    .edit-food-container textarea {
        resize: vertical;
        min-height: 100px;
    }

    .edit-food-container button {
        background-color: #405c45;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 3px;
        font-size: 16px;
        margin-top: 15px;
    }

    .edit-food-container button:hover {
        background-color: #555;
    }

    .edit-food-container p {
        text-align: center;
        margin-top: 10px;
    }

    .edit-food-container p a {
        color: #405c45;
        text-decoration: none;
    }

    .edit-food-container p a:hover {
        text-decoration: underline;
    }

    .edit-food-container select {
        padding: 10px;
        font-size: 16px;
        border: 1px solid #ccc;
        border-radius: 3px;
        width: 100%;
        height: 40px;
        max-width: 100%;
        margin-bottom: 15px;
        box-sizing: border-box;
    }

    .edit-food-container select option {
        padding: 10px;
        font-size: 16px;
    }

    .edit-food-container select option:hover {
        background-color: #f0f0f0;
    }

    .edit-food-container select option:checked {
        font-weight: bold;
        color: #405c45;
    }
    </style>
</head>

<body>
    <div class="edit-food-container">
        <h2>Edit Food Item</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]) . "?id=" . $food_data['id']; ?>" method="post"
            enctype="multipart/form-data">
            <!-- Hidden input field to store food ID -->
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($food_data['id']); ?>">

            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($food_data['name']); ?>"
                required>

            <label for="description">Description:</label>
            <textarea id="description" name="description"
                required><?php echo htmlspecialchars($food_data['description']); ?></textarea>

            <label for="price">Price (LKR):</label>
            <input type="number" id="price" name="price" min="0" step="0.01"
                value="<?php echo htmlspecialchars($food_data['price']); ?>" required>

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="">Select a category...</option>
                <option value="All Day Brekkie"
                    <?php if ($food_data['category'] == 'All Day Brekkie') echo 'selected'; ?>>All Day Brekkie</option>
                <option value="LunchTime Mains"
                    <?php if ($food_data['category'] == 'LunchTime Mains') echo 'selected'; ?>>LunchTime Mains</option>
                <option value="Burger & Tacos"
                    <?php if ($food_data['category'] == 'Burger & Tacos') echo 'selected'; ?>>Burger & Tacos</option>
                <option value="Desserts" <?php if ($food_data['category'] == 'Desserts') echo 'selected'; ?>>Desserts
                </option>
                <option value="Beverages" <?php if ($food_data['category'] == 'Beverages') echo 'selected'; ?>>Liquids
                </option>
            </select>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*">
            <img src="<?php echo htmlspecialchars($food_data['image']); ?>" alt="Current Image" width="100">

            <button type="submit">Update Food Item</button>
        </form>
        <p><a href="adminfoodmenu.php">Go Back</a></p>
    </div>
</body>

</html>