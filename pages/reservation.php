<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.css">
    <title>Reservation</title>
    <!-- Font Awesome CDN link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <style>
        .reservation-section {
            padding: 30px 20px;
            text-align: center;
        }

        .reservation-content {
            max-width: 800px;
            margin: 0 auto;
        }

        .reservation-content p {
            font-family: "Museo Sans Rounded", sans-serif;
            font-weight: 300;
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
            line-height: 1.6;
        }

        .reservation-content .reservation-times {
            font-family: "Museo Sans Rounded", sans-serif;
            font-weight: 400;
            font-size: 16px;
            color: #333;
            line-height: 1.6;
            display: block;
            margin-bottom: 40px;
        }

        .search-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 40px 0;
        }

        .search-bar form {
            display: flex;
            gap: 10px;
        }

        .search-bar select {
            flex: 2;
            padding: 10px;
            padding-right: 100px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-bar input[type="text"] {
            flex: 1;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .search-bar button {
            padding: 10px 20px;
            background-color: #405c45;
            color: #fffcda;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        .search-bar button:hover {
            background-color: #324a34;
        }

        .image-row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            margin-left: 30px;
            margin-right: 30px;

        }

        .image-item {
            flex: 1 1 calc(33.333% - 20px);
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); 
            border-radius: 10px; 
            overflow: hidden; 
            background-color: #fff; 
        }

        .image-item img {
            width: 100%;
            height: auto;
            display: block;
        }

        .image-item .description {
            padding: 10px;
            text-align: center;
        }

        .image-item .description p {
            margin: 0;
            font-size: 16px;
            color: #333;
        }

        .reserve-button .reserve-icon {
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
            box-shadow: 2px 3px 4px rgba(0, 0, 0, 0.3), 4px 7px 15px rgba(0, 0, 0, 0.3), 9px 15px 25px rgba(0, 0, 0, 0.2);
            transition: transform 0.2s ease-in-out;
        }

        .reserve-button .reserve-icon i {
            margin: 0;
        }

        .reserve-button {
            position: fixed;
            bottom: 40px;
            right: 40px;
            z-index: 999;
            text-align: center;
        }

        .reserve-button .reserve-icon:hover {
            background-color: #858585;
            transform: scale(1.1);
        }

        .reserve-button .reserve-icon p {
            margin: 5px 0 0;
            font-size: 13px;
            color: white;
            line-height: 1;
        }
    </style>
</head>

<body>
    <?php include("../Components/navigationbar.php"); ?>

    <h2 class="section-heading">CHECK THE AVAILABILITY</h2>

    <div class="search-bar">
        <form id="searchForm">
            <select name="meal" id="meal">
                <option value="breakfast">Breakfast</option>
                <option value="lunch">Lunch</option>
                <option value="dinner">Dinner</option>
            </select>
            <input type="text" id="datepicker" name="date" placeholder="Select Date">
            <button type="submit">Search</button>
        </form>
    </div>

    <div id="search-results" class="search-results">
        <div class="image-row">
            <div class="image-item">
                <img src="../images/table1.jpeg" alt="Duos Delight">
                <div class="description">
                    <p>Duos Delight: A cozy corner table with a view.</p>
                </div>
            </div>
            <div class="image-item">
                <img src="../images/table5.jpeg" alt="Table 2">
                <div class="description">
                    <p>Table 2: Ideal for intimate dinners.</p>
                </div>
            </div>
            <div class="image-item">
                <img src="../images/table6.jpeg" alt="Table 3">
                <div class="description">
                    <p>Table 3: Perfect for larger groups.</p>
                </div>
            </div>
        </div>
        <div class="image-row">
            <div class="image-item">
                <img src="../images/table2.jpeg" alt="Table 4">
                <div class="description">
                    <p>Table 4: Stylish and elegant setup.</p>
                </div>
            </div>
            <div class="image-item">
                <img src="../images/table7.jpeg" alt="Table 5">
                <div class="description">
                    <p>Table 5: Modern design for a trendy experience.</p>
                </div>
            </div>
            <div class="image-item">
                <img src="../images/table9.jpeg" alt="Rooftop Special Table">
                <div class="description">
                    <p>Rooftop Special Table: Enjoy the best view.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="reservation-section">
        <div class="reservation-content">
            <h2 class="section-heading">ABOUT RESERVATION</h2>
            <p>At The Gallery Cafe, we offer table reservations for breakfast, lunch, and dinner. Whether you're
                starting your day with a hearty breakfast, enjoying a leisurely lunch, or indulging in a delightful dinner, we have you covered.</p>
            <span class="reservation-times">Our reservation times are as follows: breakfast from 8:00 AM to 10:30 AM,
                lunch from 12:00 PM to 2:30 PM, and dinner from 6:00 PM to 9:00 PM. We look forward to providing you
                with an unforgettable dining experience.</span>
        </div>
    </div>

    <div class="reserve-button">
        <a href="reservationform.php" class="reserve-icon btn btn-primary btn-lg">
            <i class="fas fa-calendar-check"></i>
            <p>Reserve</p>
        </a>
    </div>

    <?php include("../Components/footer.php"); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.13/flatpickr.min.js"></script>
    <script>
    flatpickr("#datepicker", {
        dateFormat: "Y-m-d",
        minDate: "today",
        defaultDate: "today",
        disable: [
            function(date) {
                // Disable today's date
                return date.getTime() === new Date().setHours(0, 0, 0, 0);
            }
        ]
    });
    </script>

</body>

</html>
