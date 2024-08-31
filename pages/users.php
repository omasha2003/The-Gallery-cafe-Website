<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>

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

    .filter-search-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
    }

    .filter-tags {
        display: flex;
        align-items: center;
    }

    .filter-tags button {
        background-color: #f0f0f0;
        color: #405c45;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        margin-left: 20px;
        border-radius: 20px;
        border: 1px solid #405c45;
        font-size: 16px;
        transition: background-color 0.3s;
    }

    .filter-tags button:hover,
    .filter-tags button:active,
    .filter-tags button:focus {
        background-color: #405c45;
        color: #f0f0f0;
        outline: none;
    }

    .filter-tags button.active {
        background-color: #405c45;
        color: #f0f0f0;
    }

    .search-bar input {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        font-size: 16px;
        width: 250px;
    }

    .search-bar img {
        position: absolute;
        color: #4CAF50;
        left: 1100px;
        top: 240px;
        width: 20px;
        height: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        background-color: #fff;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    th,
    td {
        padding: 15px;
        text-align: left;
        border-bottom: 1px solid #ddd;
    }

    th {
        background-color: #405c45;
        color: white;
    }

    .btn {
        display: inline-block;
        padding: 10px 20px;
        margin: 5px;
        color: #fff;
        background-color: #405c45;
        border: none;
        border-radius: 5px;
        text-align: center;
        cursor: pointer;
        text-decoration: none;
        transition: background-color 0.3s;
    }

    .btn.manage {
        background-color: #bba586;
    }

    .btn.delete {
        background-color: #f44336;
    }

    .btn.manage:hover {
        opacity: 70%;
    }

    .btn.delete:hover {
        opacity: 70%;
    }

    .add-user-button .add-user-icon {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        width: 60px;
        height: 75px;
        border-radius: 50%;
        background-color: #405c45;
        color: #fff;
        border: none;
        cursor: pointer;
        text-decoration: none;
        box-shadow: 2px 3px 4px rgba(0, 0, 0, 0.3), 4px 7px 15px rgba(0, 0, 0, 0.3), 9px 15px 25px rgba(0, 0, 0, 0.2);
        transition: transform 0.2s ease-in-out;
    }

    .add-user-button .add-user-icon i {
        margin: 0;
    }

    .add-user-button {
        position: fixed;
        bottom: 40px;
        right: 40px;
        z-index: 999;
        text-align: center;
    }

    .add-user-button .add-user-icon:hover {
        background-color: #858585;
        transform: scale(1.1);
    }

    .add-user-button .add-user-icon p {
        margin: 5px 0 0;
        font-size: 13px;
        color: white;
        line-height: 1;
    }
    </style>
</head>

<body>
    <?php include("../Components/adminnavbar.php"); ?>

    <div class="container">
        <div class="filter-search-bar">
            <div class="filter-tags">
                <button onclick="filterUsers('all')">All</button>
                <button onclick="filterUsers('admin')">Admin</button>
                <button onclick="filterUsers('staff')">Staff</button>
                <button onclick="filterUsers('customer')">Customer</button>
            </div>
            <div class="search-bar">
                <img src="../Images/search_icon.png" alt="Search Icon">
                <input type="text" id="search-input" onkeyup="searchTable()" placeholder="Search users...">
            </div>
        </div>

        <table id="user-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Profile Pic</th>
                    <th>Username</th>
                    <th>Phone Number</th>
                    <th>Address</th>
                    <th>Email</th>
                    <th>Account Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include("../Components/db.php");

                    $query = "SELECT id, username, phonenumber, address, email, acc_type, image FROM userdetails";
                    $result = mysqli_query($con, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>";
                        if (!empty($row['image'])) {
                            echo "<img src='" . $row['image'] . "' alt='User Image' width='50' height='50'>";
                        } else {
                            echo "No Image";
                        }
                        echo "<td>" . $row['username'] . "</td>";
                        echo "<td>" . $row['phonenumber'] . "</td>";
                        echo "<td>" . $row['address'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>" . $row['acc_type'] . "</td>";
                        echo "</td>";
                        echo "<td>";
                        echo "<a href='update_user.php?id=" . $row['id'] . "' class='btn manage'>Manage</a>";
                        echo "<a href='#' class='btn delete' onclick='confirmDelete(" . $row['id'] . ")'>Delete</a>";
                    echo "</td>" ; echo "</tr>" ; } mysqli_close($con); ?>
            </tbody>
        </table>
    </div>

    <div class="add-user-button">
        <a href="admin_registrationform.php" class="add-user-icon btn btn-primary btn-lg">
            <i class="fas fa-user-plus"></i>
            <p>New User</p>
        </a>
    </div>

    <!-- Custom JS file link -->
    <script src="../js/script.js"></script>
    <script>
    document.addEventListener("DOMContentLoaded", function() {
        const filterButtons = document.querySelectorAll(".filter-tags button");

        filterButtons.forEach(button => {
            button.addEventListener("click", function() {
                filterButtons.forEach(btn => btn.classList.remove("active"));
                this.classList.add("active");
            });
        });
    });

    function filterUsers(type) {
        var rows = document.querySelectorAll("#user-table tbody tr");

        rows.forEach(function(row) {
            if (type === 'all') {
                row.style.display = '';
            } else {
                var accType = row.querySelector("td:nth-child(7)").innerText.trim();
                console.log(`Filtering by: ${type}, Row account type: ${accType}`);
                if (accType.toLowerCase() === type.toLowerCase()) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            }
        });
    }

    function searchTable() {
        var input, filter, table, tr, td, i, txtValue;
        input = document.getElementById("search-input");
        filter = input.value.toLowerCase();
        table = document.getElementById("user-table");
        tr = table.getElementsByTagName("tr");

        for (i = 1; i < tr.length; i++) {
            tr[i].style.display = "none";
            td = tr[i].getElementsByTagName("td");
            for (var j = 0; j < td.length; j++) {
                if (td[j]) {
                    txtValue = td[j].textContent || td[j].innerText;
                    if (txtValue.toLowerCase().indexOf(filter) > -1) {
                        tr[i].style.display = "";
                        break;
                    }
                }
            }
        }
    }

    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this user?")) {
            window.location.href = `deleteuser.php?id=${id}`;
        }
    }
    </script>
</body>

</html>