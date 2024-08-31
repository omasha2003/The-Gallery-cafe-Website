<?php
session_start();

include("../Components/db.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">

    <title>Contact</title>
</head>

<body>
    <?php include("../Components/navigationbar.php"); ?>

    <div class="content-wrapper">
        <div class="main-content">
            <h2>CONTACT US</h2>
            <p>Feel free to reach out to us with any questions, feedback, or reservation inquiries. We're here to assist
                you!</p>
            <p>Whether you're planning a visit, seeking more information about our menu, or simply want to connect, we'd
                love to hear from you.</p>
        </div>
        <div class="sidebar">
            <h2>GALLERY CAFE</h2>
            <p>3/1 The Avenue<br>
                (Off Independence Avenue),<br>
                Colombo 7, Sri Lanka</p>
            <p><span>Opening Hours:<br>
                    9am–6pm, Mon-Sun<br>
                    Closed on Poya days</span></p>
            <a href="tel:+94112223344" class="button">Call Us</a>
        </div>
    </div>
    <div class="content-wrapper">
        <div class="sidebar">
            <img style="margin-top: -80%; margin-bottom: -0%;  width: 200%; height: auto; "
                src="../Images/location.png">
        </div>
    </div>

    <?php include("../Components/footer.php"); ?>
</body>

</html>