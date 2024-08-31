<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">

    <title>Our Cafe</title>
    <style>
        .content-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .main-content {
            flex: 2;
            padding-right: 20px;
        }

        .video-wrapper {
            flex: 1;
        }

        .video-wrapper video {
            width: 100%;
            height: auto;
            max-height: 400px; /* Adjust this value as needed */
            border: 1px solid #ddd; /* Optional: border around the video */
            border-radius: 8px; /* Optional: rounded corners for the video */
        }

        .photo-gallery {
            display: flex;
            justify-content: center;
            margin-top: 30px;
            margin-left: 40px;
            margin-right: 40px;
            margin-bottom: 50px;
        }

        .photo-gallery img {
            width: 25%; /* Reduced width to make the images smaller */
            height: auto;
            border-radius: 10px; /* Optional: rounded corners for the images */
            border: 2px solid #ddd; /* Optional: border around the images */
        }

        .photo-gallery img:not(:last-child) {
            margin-right: 0.5%; /* Reduced spacing between images */
        }
    </style>
</head>

<body>
    <?php include("../Components/navigationbar.php"); ?>

    <h2 class="section-heading">AS FEATURED ON</h2>

    <img src="../Images/bbcTravel.png" alt="Logo" class="sponsor-logo">

    <div class="content-wrapper">
        <div class="main-content">
            <h2>NESTLED IN THE VIBRANT CITY OF COLOMBO, THE GALLERY CAFE IS A SPACE THAT PROMOTES HEALTHY AND SUSTAINABLE LIVING.</h2>
            <p>Inspired by the elegance of art galleries and the warmth of traditional hospitality,
             The Gallery Café offers a unique blend of gourmet cuisine, fine beverages, and a cozy yet sophisticated atmosphere.
              Whether you're savoring our chef's special dishes, enjoying a cup of freshly brewed coffee, or simply soaking in the serene surroundings,
               every visit to The Gallery Café promises a delightful journey for the senses.</p>
            <p>Join us and be a part of our story—where every meal is a masterpiece and every guest is family.</p>
        </div>

        <div class="video-wrapper">
            <video controls>
                <source src="../Videos/cafevdo.mp4" type="video/mp4">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>

    <div class="photo-gallery">
        <img src="../Images/promotions.jpeg" alt="Photo 1">
        <img src="../Images/food poster.jpeg" alt="Photo 2">
        <img src="../Images/Restaurant Promotion.jpeg" alt="Photo 3">
    </div>

    <?php include("../Components/footer.php"); ?>
</body> 

</html>
