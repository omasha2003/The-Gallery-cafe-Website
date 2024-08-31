<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Foods</title>

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <!-- Custom CSS file link -->
    <link rel="stylesheet" href="../css/admin_styles.css">
</head>

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

.filter-container select {
    padding: 10px;
    margin-left: 13px;
    font-size: 16px;
    border: 1px solid #ccc;
    border-radius: 3px;
}

.search-bar {
    position: relative;
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
    top: 10px;
    left: -30px;
    width: 20px;
    height: 20px;
}

.add-food-button .add-food-icon {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 58px;
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

.add-food-button .add-food-icon i {
    margin: 0;
}

.add-food-button {
    position: fixed;
    bottom: 40px;
    right: 40px;
    z-index: 999;
    text-align: center;
}

.add-food-button .add-food-icon:hover {
    background-color: #858585;
    transform: scale(1.1);
}

.add-food-button .add-food-icon p {
    margin: 5px 0 0;
    font-size: 13px;
    color: white;
    line-height: 1;
}

img {
    height: 100px;
    width: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    background-color: #fff;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    margin-bottom: 100px;
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
    width: 55px;
    background-color: #f44336;
}

.btn.manage:hover {
    opacity: 70%;
}

.btn.delete:hover {
    opacity: 70%;
}
</style>

<body>
    <?php include("../Components/adminnavbar.php"); ?>

    <div class="container">
        <div class="filter-search-bar">
            <div class="filter-container">
                <label for="category-filter">Filter by Category : </label>
                <select id="category-filter" onchange="filterTable()">
                    <option value="">All Categories</option>
                    <option value="Sri Lankan">Sri Lankan</option>
                    <option value="Chineese">Chineese</option>
                    <option value="Italian">Italian</option>
                    <option value="Burger & Tacos">Burger & Tacos</option>
                    <option value="Desserts">Desserts</option>
                    <option value="Beverages">Beverages</option>
                </select>
            </div>

            <div class="search-bar">
                <img src="../Images/search_icon.png" alt="Search Icon">
                <input type="text" id="search-input" onkeyup="searchTable()" placeholder="Search Food...">
            </div>
        </div>

        <table id="food-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Category</th>
                    <th>Manage</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    include("../Components/db.php");

                    $query = "SELECT * FROM menu";
                    $result = mysqli_query($con, $query);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>" . $row['id'] . "</td>";
                        echo "<td>";
                        if (!empty($row['image'])) {
                            echo "<img src='" . $row['image'] . "' alt='Food Image' width='50' height='50'>";
                        } else {
                            echo "No Image";
                        }
                        echo "<td>" . $row['name'] . "</td>";
                        echo "<td>" . $row['description'] . "</td>";
                        echo "<td>" . $row['price'] . "</td>";
                        echo "<td>" . $row['category'] . "</td>";
                        echo "</td>";
                        echo "<td>";
                        echo "<a href='update_foodmenu.php?id=" . $row['id'] . "' class='btn manage'>Manage</a>";
                        echo "<a href='#' class='btn delete' onclick='confirmDelete(" . $row['id'] . ")'>Delete</a>";
                        echo "</td>";
                        echo "</tr>";
                    }

                    mysqli_close($con);
                ?>
            </tbody>
        </table>
    </div>
    <div class="add-food-button">
        <a href="admin_addfoodsform.php" class="add-food-icon btn btn-primary btn-lg">
            <i class="fas fa-hamburger"></i>
            <p>New Food</p>
        </a>
    </div>

    <script>
    function filterTable() {
        const filter = document.getElementById('category-filter').value.toLowerCase();
        const rows = document.querySelectorAll('#food-table tbody tr');

        rows.forEach(row => {
            const category = row.children[5].textContent.toLowerCase();
            if (filter === "" || category.includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    function searchTable() {
        const input = document.getElementById('search-input').value.toLowerCase();
        const rows = document.querySelectorAll('#food-table tbody tr');

        rows.forEach(row => {
            const name = row.children[2].textContent.toLowerCase();
            const description = row.children[3].textContent.toLowerCase();
            const category = row.children[5].textContent.toLowerCase();

            if (name.includes(input) || description.includes(input) || category.includes(input)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    function confirmDelete(id) {
        if (confirm("Are you sure you want to delete this food item?")) {
            window.location.href = 'deletefoods.php?id=' + id;
        }
    }
    </script>

    <!-- Custom JS file link -->
    <script src="../js/script.js"></script>
</body>

</html>