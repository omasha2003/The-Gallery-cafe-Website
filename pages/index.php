<?php


include("../Components/db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">


    <title>The Gallery Cafe`</title>
</head>
<style>
.half-circle-rectangle {
    width: 110px;
    /* Width of the rectangle */
    height: 90px;
    /* Height of the rectangle and diameter of the half-circle */
    background-color: #405c45;
    /* Rectangle color */
    position: fixed;
    top: 200px;
    right: 0;
    z-index: 1000;
    /* Ensure the rectangle is in front */
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 2px 3px 4px rgba(0, 0, 0, 0.3), 4px 7px 15px rgba(0, 0, 0, 0.3), 9px 15px 25px rgba(0, 0, 0, 0.2);
    transition: transform 0.2s ease-in-out;
}

.half-circle-rectangle::before {
    content: "";
    width: 90px;
    /* Diameter of the half-circle */
    height: 90px;
    /* Diameter of the half-circle */
    background-color: #405c45;
    /* Same color as the rectangle */
    border-radius: 45px 0 0 45px;
    /* Create the half-circle shape */
    position: absolute;
    left: -40px;
    /* Position the half-circle to the left side of the rectangle */
    top: 0;
    z-index: 999;
    /* Ensure the half-circle is behind the rectangle */
}

.profile-icon {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background-color: #405c45;
    color: #fff;
    border: none;
    cursor: pointer;
    font-size: 24px;
    text-decoration: none;
    z-index: 1001;
}

.profile-icon p {
    margin: 5px 0 0;
    font-size: 13px;
    color: white;
    line-height: 1;
}

.user-profile {
    display: flex;
    align-items: center;
    margin-right: 20px;
}

.user-profile img {
    height: 50px;
    width: 50px;
    border-radius: 50%;
    object-fit: cover;
    margin-right: 10px;
}

.login-txt,
.username {
    font-size: 18px;
    margin-right: 20px;
    color: #fffcda;
}

.login-txt {
    text-decoration: underline;
}

.img-square {
    margin-left: -10%;
    margin-top: 9%;
    height: 95%;
    width: 100%;
}
</style>
<body>
    <?php include("../Components/navigationbar.php"); ?>
    
    <div class="half-circle-rectangle">
        <a class="profile-icon"
            href="<?php echo isset($_SESSION['username']) ? '../Pages/userprofile.php' : '../Pages/login.php'; ?>">
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
                    echo "<img src='../Images/def_img.png' alt='default-user-image' class='default-user-image'>";
                }
                echo "<div class='user-info'>";
                echo "<div class='username'>$username</div>";
                echo "</div>";
            } else {
                echo "<img src='../Images/def_img.png' alt='default-user-image' class='default-user-image'>";
                echo "<div class='login-txt'>Login</div>";
            }
            ?>
            </div>
        </a>
    </div>
 
    <img src="../images/homeimage2.png" alt="Home Image" class="home-image">

    <h2 class="section-heading">AS FEATURED ON</h2>

    <img src="../images/bbcTravel.png" alt="Logo" class="sponsor-logo">

    <div class="content-wrapper">
        <div class="main-content">
            <h2>NESTLED IN THE VIBRANT CITY OF COLOMBO, GALLERY CAFE IS A SPACE THAT PROMOTES HEALTHY AND SUSTAINABLE LIVING.
            </h2>
            <p>Inspired by the elegance of art galleries and the warmth of traditional hospitality,
             The Gallery Café offers a unique blend of gourmet cuisine, fine beverages, and a cozy yet sophisticated atmosphere.
              Whether you're savoring our chef's special dishes, enjoying a cup of freshly brewed coffee, or simply soaking in the serene surroundings,
               every visit to The Gallery Café promises a delightful journey for the senses.</p>
            <p>Join us and be a part of our story—where every meal is a masterpiece and every guest is family.</p>
        </div>
        <div class="sidebar">
            <h2>THE GALLERY CAFE</h2>
            <p>3/1 , Colombo 7 <br>
                Sri Lanka</p>
            <p><span>9am–6pm Mon, Wed-Sun<br>
                    Closed on poya day.</span></p>
            <a href="reservation.php" class="button">Make a Reservation</a>
        </div>
    </div>

    <img src="../images/homeimage3.png" alt="Home Image" class="home-image">


    <div class="content-wrapper">
        <div class="sidebar">
            <img src="../images/Gallery.jpeg" alt="Cafe image" class="cafe-image">
        </div>
        <div class="main-content">
            <p>In December 2012, after studying culinary arts in Paris, I returned to Sri Lanka with a dream to blend food and art.
                 With my friend Hansa, we found the perfect spot in an old colonial building in Colombo. 
                 Restoring it with care, we opened The Gallery Café in April 2013.
            </p>
            <p>Our principles are simple: quality and authenticity, exceptional customer service, and a serene, art-filled ambiance.
                 We serve a fusion of Sri Lankan and international flavors, using only fresh, local ingredients.</p>
            <p>Over the years, The Gallery Café has become a cultural hub, hosting art exhibitions, live music, and community events. 
                In 2018, we added a rooftop garden, offering a tranquil escape in the city.</p>
            <p>Our journey has been amazing, filled with challenges and triumphs.
                 We owe our success to our cherished customers.
                  Thank you for being part of our story. We look forward to welcoming you to The Gallery Café, where every visit is a celebration of Sri Lankan culture.</p>         
        </div>
    </div>
    <?php include("../components/footer.php"); ?>
    
</body>
</html>