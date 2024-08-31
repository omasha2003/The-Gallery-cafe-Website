<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin-Portal</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_style.css">
</head>

<style>
body {
    background-color: #f2f2f2;
}

.dashboard-section {
    background-color: #f2f2f2;
    padding: 30px;
}

.dashboard-section h2 {
    font-size: 24px;
    /* Decreased font size */
    font-weight: 600;
    /* Slightly lighter weight */
    color: #35424a;
    /* Darker color */
    margin-bottom: 15px;
    /* Reduced margin */
}

.dashboard-cards {
    display: flex;
    gap: 15px;
    /* Reduced gap between cards */
    justify-content: space-around;
    /* Centered cards with space around them */
}

.dashboard-card {
    background-color: #f9f9f9;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    flex: 1;
    transition: transform 0.3s ease-in-out;
}

.dashboard-card:hover {
    transform: translateY(-5px);
}

.dashboard-card i {
    color: #405c45;
    font-size: 40px;
}

.card-info {
    margin-top: 10px;
    text-align: center;
}

.card-info h3 {
    font-size: 18px;
    font-weight: 600;
    margin-top: -18px;
    color: #35424a;
}

.card-info p {
    padding: 0%;
    font-size: 30px;
    font-weight: 600;
    color: #35424a;
}


.section-heading {
    margin-top: 60px;
    color: #405c45;
    font-size: 17px;
    font-weight: 300;
    text-align: center;
    margin-bottom: 30px;
    letter-spacing: 1px;
}
</style>

<body>
    <?php include("../Components/adminnavbar.php"); ?>

    <div class="dashboard-section">
        <h2>Dashboard</h2>
        <div class="dashboard-cards">
            <!-- Total Orders Card -->
            <div class="dashboard-card">
                <i class="fas fa-shopping-cart fa-3x"></i>
                <div class="card-info">
                    <h3>Total Orders</h3>
                    <?php
                // Fetch total orders from database
                $query = "SELECT COUNT(*) AS total_orders FROM order_details";
                $result = mysqli_query($con, $query);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $total_orders = $row['total_orders'];
                    echo "<p>$total_orders</p>";
                } else {
                    echo "<p>Unable to fetch data</p>";
                }
                ?>
                </div>
            </div>

            <!-- Total Reservations Card -->
            <div class="dashboard-card">
                <i class="fas fa-calendar-alt fa-3x"></i>
                <div class="card-info">
                    <h3>Total Reservations</h3>
                    <?php
                // Example: Fetch total reservations from database
                $query = "SELECT COUNT(*) AS total_reservations FROM reservations";
                $result = mysqli_query($con, $query);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $total_reservations = $row['total_reservations'];
                    echo "<p>$total_reservations</p>";
                } else {
                    echo "<p>Unable to fetch data</p>";
                }
                ?>
                </div>
            </div>

            <!-- Total Foods Card -->
            <div class="dashboard-card">
                <i class="fas fa-utensils fa-3x"></i>
                <div class="card-info">
                    <h3>Total Foods</h3>
                    <?php
                // Example: Fetch total foods from database
                $query = "SELECT COUNT(*) AS total_foods FROM menu";
                $result = mysqli_query($con, $query);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $total_foods = $row['total_foods'];
                    echo "<p>$total_foods</p>";
                } else {
                    echo "<p>Unable to fetch data</p>";
                }
                ?>
                </div>
            </div>

            <!-- Total Staff Members Card -->
            <div class="dashboard-card">
                <i class="fas fa-user-friends fa-3x"></i>
                <div class="card-info">
                    <h3>Total Staff Members</h3>
                    <?php
                // Example: Fetch total staff members from database
                $query = "SELECT COUNT(*) AS total_staff FROM userdetails WHERE acc_type = 'staff'";
                $result = mysqli_query($con, $query);

                if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $total_staff = $row['total_staff'];
                    echo "<p>$total_staff</p>";
                } else {
                    echo "<p>Unable to fetch data</p>";
                }
                ?>
                </div>
            </div>
        </div>
    </div>

    <?php mysqli_close($con); ?>
    <h2 class="section-heading">WELCOME TO ADMIN POTRAL</h2>

    <!-- Custom JS file link -->
    <script src="../js/script.js"></script>
    <?php include("../Components/footer.php"); ?>
</body>

</html>