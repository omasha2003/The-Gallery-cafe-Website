<?php
session_start();
include("../Components/db.php");

$error = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($con, $_POST['username']);
    $password = $_POST['password'];

    $query = "SELECT * FROM userdetails WHERE username = ?";
    $stmt = mysqli_prepare($con, $query);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        if (password_verify($password, $user['password'])) {
            // Password is correct, log the user in
            $_SESSION['username'] = $username;
            
            // Determine redirect based on account type
            switch ($user['acc_type']) {
                case 'admin':
                    header("Location: ../Pages/admin_home.php");
                    exit();
                case 'staff':
                    header("Location: ../Pages/staffhome.php");
                    exit();
                case 'customer':
                    header("Location: ../Pages/index.php");
                    exit();
                default:
                    $error = "Invalid account type.";
                    break;
            }
        } else {
            $error = "Incorrect password.";
        }
    } else {
        $error = "User not found.";
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
    <title>Login - The Gallery Café</title>
</head>

<body>
    <style>
    .register-container,
    .login-container {
        max-width: 400px;
        margin: 50px auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-top: 175px;
        margin-bottom: 230px;

    }

    .register-container h2,
    .login-container h2 {
        font-weight: 600;
        margin-bottom: 20px;
        text-align: center;
    }

    .register-container form,
    .login-container form {
        display: flex;
        flex-direction: column;
    }

    .register-container label,
    .login-container label {
        margin-bottom: 10px;
    }

    .register-container input,
    .login-container input {
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ccc;
        border-radius: 3px;
        font-size: 16px;

    }

    .register-container button,
    .login-container button {
        background-color: #405c45;
        color: #fff;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 3px;
        font-size: 16px;
        margin-top: 15px;
    }

    .register-container button:hover,
    .login-container button:hover {
        background-color: #555;
    }

    .register-container p,
    .login-container p {
        text-align: center;
        margin-top: 10px;
    }

    .register-container p a,
    .login-container p a {
        color: #405c45;
        text-decoration: none;
    }

    .register-container p a:hover,
    .login-container p a:hover {
        text-decoration: underline;
    }
    </style>
    <div class="login-container">
        <h2>LOGIN </h2>
        <?php if (isset($error)): ?>
        <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>
        <form action="login.php" method="post">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>

            <button type="submit">Login</button>

        </form>
        <p>Don't have an account? <a href="registration.php">Register now</a></p>
    </div>

    <?php include("../components/footer.php"); ?>
</body>

</html>
