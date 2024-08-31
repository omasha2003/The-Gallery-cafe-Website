<?php
session_start();
include("../Components/db.php");

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $phonenumber = mysqli_real_escape_string($con, $_POST['phonenumber']);
    $address = mysqli_real_escape_string($con, $_POST['address']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    // Check if email already exists
    $check_email_query = "SELECT * FROM userdetails WHERE email = ?";
    $stmt = mysqli_prepare($con, $check_email_query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $check_result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($check_result) > 0) {
        $errors[] = "Email already exists";
    }

    // File upload handling
    $target_dir = "../uploads/";
    $uniqueFilename = uniqid('profile_', true) . '.' . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    $target_file = $target_dir . $uniqueFilename;
    $uploadOk = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if image file is an actual image or fake image
    if (isset($_FILES["image"]["tmp_name"])) {
        $check = getimagesize($_FILES["image"]["tmp_name"]);
        if ($check === false) {
            $errors[] = "File is not an image.";
            $uploadOk = 0;
        }
    } else {
        $errors[] = "No file uploaded.";
        $uploadOk = 0;
    }

    // Check file size (500KB limit)
    if ($_FILES["image"]["size"] > 500000) {
        $errors[] = "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Allow only certain file formats
    $allowed_formats = array("jpg", "jpeg", "png", "gif");
    if (!in_array($imageFileType, $allowed_formats)) {
        $errors[] = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 by an error
    if ($uploadOk == 0) {
        $errors[] = "Sorry, your file was not uploaded.";
    } else {
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
            // File uploaded successfully, now insert data into database
            $image_path = $target_file;

            // Hash password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $acc_type = 'customer';  // Set account type to customer by default

            // Insert user details into database using prepared statement
            $insert_query = "INSERT INTO userdetails (username, image, phonenumber, address, email, password, acc_type) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt = mysqli_prepare($con, $insert_query);
            mysqli_stmt_bind_param($stmt, "sssssss", $username, $image_path, $phonenumber, $address, $email, $hashed_password, $acc_type);

            if (mysqli_stmt_execute($stmt)) {
                // Registration successful, set a session variable and redirect smoothly
                $_SESSION['username'] = $username;
                echo "<script>alert('Registration successful!'); window.location.href='../Pages/login.php';</script>";
                exit();
            } else {
                $errors[] = "Error: " . mysqli_error($con);
            }
        } else {
            $errors[] = "Sorry, there was an error uploading your file.";
        }
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
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <title>Register - The Gallery Café</title>
</head>

<body>

    <div class="register-container">
        <h2>Register</h2>
        <?php if (!empty($error)) : ?>
        <p><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"
            enctype="multipart/form-data">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="image">Select a picture:</label>
            <input type="file" id="image" name="image" accept="image/*" required>

            <label for="phonenumber">Phone Number:</label>
            <input type="text" id="phonenumber" name="phonenumber" required>

            <label for="address">Address:</label>
            <input type="text" id="address" name="address" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>

            <button type="submit">Register</button>
        </form>
        <p>Already have an account? <a href="login.php"> Log in</a></p>
    </div>

    <?php include("../Components/footer.php"); ?>
</body>

</html>