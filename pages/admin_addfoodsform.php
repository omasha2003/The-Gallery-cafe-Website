<?php
include("../Components/db.php");

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if form data exists
    if (isset($_POST['name'], $_POST['description'], $_POST['price'], $_POST['category'], $_FILES['image'])) {
        // Get form data
        $name = mysqli_real_escape_string($con, $_POST['name']);
        $description = mysqli_real_escape_string($con, $_POST['description']);
        $price = mysqli_real_escape_string($con, $_POST['price']);
        $category = mysqli_real_escape_string($con, $_POST['category']);
        
        // Handle image upload
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $target_dir = "../uploads/";
            $imageFileType = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
            $uniqueFilename = uniqid('food_', true) . '.' . $imageFileType;
            $target_file = $target_dir . $uniqueFilename;
            $uploadOk = 1;

            // Check if file already exists
            if (file_exists($target_file)) {
                $errors[] = "Sorry, file already exists.";
                $uploadOk = 0;
            }

            // Check file size
            if ($_FILES['image']['size'] > 5000000) {
                $errors[] = "Sorry, your file is too large.";
                $uploadOk = 0;
            }

            // Allow certain file formats
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                $uploadOk = 0;
            }

            // Check if $uploadOk is set to 0 by an error
            if ($uploadOk == 0) {
                $errors[] = "Sorry, your file was not uploaded.";
            } else {
                // Attempt to upload file
                if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                    $image_path = $target_file;
                } else {
                    $errors[] = "Sorry, there was an error uploading your file.";
                }
            }
        } else {
            $errors[] = "No image file was uploaded.";
        }

        // Insert data into database if there are no errors
        if (empty($errors) && isset($image_path)) {
            $query = "INSERT INTO menu (name, description, price, category, image) VALUES ('$name', '$description', '$price', '$category', '$image_path')";
            if (mysqli_query($con, $query)) {
                echo "<script>alert('New food item added successfully!'); window.location.href='../Pages/adminfoodmenu.php';</script>";
                exit;
            } else {
                $errors[] = "Error: " . mysqli_error($con);
            }
        }
    } else {
        $errors[] = "All form fields are required.";
    }
}

// Display errors
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo "<p>Error: $error</p>";
    }
}

mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
 
    <title>Add New Food Item</title>
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

    .add-food-container {
        width: 500px;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 50px;
    }

    .add-food-container h2 {
        font-weight: 600;
        margin-bottom: 20px;
        text-align: center;
        color: #405c45;
    }

    .add-food-container form {
        display: flex;
        flex-direction: column;
    }

    .add-food-container label {
        margin-bottom: 10px;
        color: #405c45;
    }

    .add-food-container input,
    .add-food-container textarea {
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 16px;
    }

    .add-food-container textarea {
        resize: vertical;
        min-height: 100px;
    }

    .add-food-container button {
        background-color: #405c45;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 3px;
        font-size: 16px;
        margin-top: 15px;
    }

    .add-food-container button:hover {
        background-color: #555;
    }

    .add-food-container p {
        text-align: center;
        margin-top: 10px;
    }

    .add-food-container p a {
        color: #405c45;
        text-decoration: none;
    }

    .add-food-container p a:hover {
        text-decoration: underline;
    }

    .add-food-container select {
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

    .add-food-container select option {
        padding: 10px;
        font-size: 16px;
    }

    .add-food-container select option:hover {
        background-color: #f0f0f0;
    }

    .add-food-container select option:checked {
        font-weight: bold;
        color: #405c45;
    }
    </style>
</head>

<body>
    <div class="add-food-container">
        <h2>Add New Food Item</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post" enctype="multipart/form-data">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>

            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>

            <label for="price">Price (LKR):</label>
            <input type="number" id="price" name="price" min="0" step="0.01" required>

            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="">Select a category...</option>
                <option value="Sri Lankan">Sri Lankan</option>
                <option value="Chineese">Chineese</option>
                <option value="Italian">Italian</option>
                <option value="Burger & Tacos">Burger & Tacos</option>
                <option value="Desserts">Desserts</option>
                <option value="Beverages">Beverages</option>
            </select>

            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <button type="submit">Add Food Item</button>
            <button type="button" class="cancel-button" onclick="window.location.href='adminfoodmenu.php'">Cancel</button>
        </form>
    </div>
</body>

</html>
