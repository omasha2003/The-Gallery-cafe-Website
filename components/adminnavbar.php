<?php
session_start();
include("../Components/db.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
    body {
        margin: 0;
        font-family: "Lato", sans-serif;
        display: flex;
        flex-direction: column;
        min-height: 100vh;
    }

    .navbar {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #405c45;
        height: 150px;
        width: 100%;
    }

    .navbar-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        width: 100%;
        padding: 0 30px;
    }

    .admin-portal {
        text-align: left;
        padding-left: 30px;
        flex: 1;
        font-size: 33px;
        font-family: "Museo Sans Rounded", sans-serif;
        font-weight: 400;
        color: #fffcda;
    }

    .logo {
        height: 100px;
        width: auto;
        margin-left: 100px;
    }

    .user-profile {
        display: flex;
        align-items: center;
        margin-right: 20px;
        /* Adjust as needed */
    }

    .user-profile img {
        height: 50px;
        width: 50px;
        border-radius: 50%;
        object-fit: cover;
        margin-right: 10px;
    }

    .username {
        font-size: 18px;
        margin-right: 20px;
        color: #fffcda;
    }

    .secondary-navbar {
        display: flex;
        justify-content: center;
        align-items: center;
        background-color: #bba586;
        height: 50px;
        width: 100%;
    }

    .secondary-nav-links {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 20px;
    }

    .secondary-nav-links li {
        display: inline;
    }

    .secondary-nav-links a {
        color: #fffcda;
        text-decoration: none;
        font-size: 18px;
        padding: 5px 10px;
        font-family: "Museo Sans Rounded", sans-serif;
        font-weight: 400;
        letter-spacing: 1px;
        border-radius: 5px;
        transition: background-color 0.3s ease, color 0.3s ease;
    }

    .secondary-nav-links a:hover {
        background-color: #324a34;
        color: #fffcda;
    }

    .spacer {
        flex: 1;
    }

    .logout a {
        color: #bba586;
        font-size: 14px;
    }

    .logout a:hover {
        color: #fffcda;
        text-decoration: underline;
    }
    </style>
</head>

<body>
    <section>
        <nav class="navbar">
            <div class="navbar-content">
                <a href="../Components/adminhome.php">
                    <img src="../Images/logo.png" alt="Logo" class="logo">
                </a>
                <div class="admin-portal">ADMIN PORTAL</div>
                <div class="user-profile">
                    <?php
                        if (isset($_SESSION['username'])) {
                            $username = $_SESSION['username'];
                            $query = "SELECT image FROM userdetails WHERE username = ?";
                            $stmt = mysqli_prepare($con, $query);
                            mysqli_stmt_bind_param($stmt, "s", $username);
                            mysqli_stmt_execute($stmt);
                            mysqli_stmt_bind_result($stmt, $image);
                            mysqli_stmt_fetch($stmt);
                            mysqli_stmt_close($stmt);
                            if (!empty($image)) {
                                echo "<img src='../uploads/$image' alt='User Image'>";
                            } else {
                                echo "<img src='../Images/default-user-image.jpg' alt='Default User Image'>";
                            }
                            echo "<div class='user-info'>";
                            echo "<div class='username'>$username</div>";
                            echo "<div class='logout'><a href='../Components/logout.php'>Logout</a></div>"; // Add the logout link
                            echo "</div>";
                            
                        }
                    ?>
                </div>
            </div>
        </nav>

        <nav class="secondary-navbar">
            <ul class="secondary-nav-links">
                <li><a href="../Pages/admin_home.php">HOME</a></li>
                <li><a href="../Pages/adminorders.php">ORDERS</a></li>
                <li><a href="../Pages/admin_reservation.php">RESERVATION</a></li>
                <li><a href="../Pages/adminfoodmenu.php">FOOD MENU</a></li>
                <li><a href="../Pages/users.php">USERS</a></li>
            </ul>
        </nav>
    </section>
</body>

</html>