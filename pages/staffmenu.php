<?php


include("../Components/db.php");

// Fetch distinct categories from the database
$category_query = "SELECT DISTINCT category FROM menu";
$category_result = mysqli_query($con, $category_query);


?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/styles.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@100;300;400;700;900&display=swap" rel="stylesheet">

    <!-- Font Awesome CDN Link -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

    <title>Menu</title>
    <style>
    body {
        margin: 0;
        padding: 0;
    }

    .title h2 {
        font-family: "Museo Sans Rounded", sans-serif;
        margin: 0;
        font-size: 2.5rem;
    }

    .intro {
        text-align: center;
        margin-bottom: 30px;
    }

    h2 {
        font-family: "Museo Sans Rounded", sans-serif;
        font-weight: 700;
    }

    .category-section {
        margin-bottom: 30px;
    }

    .section-title {
        font-size: 1.5rem;
        font-weight: bold;
        color: #405c45;
        margin-bottom: 10px;
        margin-top: 20px;
        margin-left: 40px;
    }

    .food-container {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 20px;
        padding: 20px;
    }

    .food-item {
        background-color: #fff;
        border-radius: 10px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .food-item:hover {
        transform: translateY(-5px);
        box-shadow: 0 0 20px rgba(0, 0, 0, 0.2);
    }

    .food-item img {
        width: 100%;
        height: 200px;
        object-fit: cover;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .food-item-content {
        padding: 15px;
    }

    .food-details {
        margin-bottom: 10px;
    }

    .food-item-title {
        font-size: 1.2rem;
        font-weight: bold;
        color: #405c45;
        margin-bottom: 5px;
    }

    .food-item-description {
        font-family: "Museo Sans Rounded", sans-serif;
        font-weight: 200;
        font-size: .94rem;
        color: #999;
        line-height: 1.4;
        margin-bottom: 10px;
    }

    .food-actions {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .food-item-price {
        bottom: 3px;
        font-size: 1.2rem;
        color: #405c45;
        font-weight: bold;
    }

    .add-to-cart-btn {
        bottom: 3px;
        padding: 8px 20px;
        background-color: #405c45;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s
    }

    .add-to-cart-btn:hover {
        background-color: #4e724f;
    }

    .my-cart-button .my-cart-icon {
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

    .my-cart-button .my-cart-icon i {
        margin: 0;
    }

    .my-cart-button {
        position: fixed;
        bottom: 40px;
        right: 40px;
        z-index: 999;
        text-align: center;
    }

    .my-cart-button .my-cart-icon:hover {
        background-color: #858585;
        transform: scale(1.1);
    }

    .my-cart-button .my-cart-icon p {
        margin: 5px 0 0;
        font-size: 13px;
        color: white;
        line-height: 1;
    }

    .cart-notification {
        position: absolute;
        top: 4px;
        right: 10px;
        background-color: #B22222;
        color: white;
        border-radius: 50%;
        padding: 5px 10px;
        font-size: 0.9rem;
        font-weight: bold;
    }

    /* Cart Sidebar CSS */
    .cart-sidebar {
        position: fixed;
        right: 0;
        top: 0;
        width: 400px;
        height: 100%;
        background-color: #fff;
        box-shadow: -2px 0 5px rgba(0, 0, 0, 0.5);
        transform: translateX(100%);
        transition: transform 0.3s ease;
        z-index: 1000;
        display: flex;
        flex-direction: column;
    }

    .cart-sidebar.active {
        transform: translateX(0);
    }

    .cart-sidebar-header {
        height: 50px;
        background-color: #405c45;
        position: relative;
    }

    .cart-sidebar-header h1 {
        background-color: #405c45;
        align-items: center;
        font-family: "Museo Sans Rounded", sans-serif;
        font-weight: 400;
        padding: 20px;
        color: #fffcda;
        text-align: center;
        font-size: 1.5rem;
    }

    .close-cart {
        position: absolute;
        top: 34px;
        right: 24px;
        font-size: 1.5rem;
        cursor: pointer;
        color: #fffcda;
    }

    .cart-sidebar-content {
        flex: 1;
        overflow-y: auto;
        padding: 25px;
        margin-top: 10px;
    }

    .cart-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 10px;
    }

    .cart-item img {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 5px;
    }

    .cart-item-details {
        flex: 1;
        margin-left: 10px;
    }

    .cart-item-title {
        font-size: 1.1rem;
        font-weight: bold;
        color: #405c45;
    }

    .cart-item-price {
        font-size: 0.8rem;
        color: #999;
    }

    .cart-item-total-price {
        margin-top: 2px;
    }

    .qty-controls {
        display: flex;
        align-items: center;
    }

    .qty-controls button {
        background-color: #405c45;
        color: #fff;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        font-size: 1rem;
        border-radius: 3%;
    }

    .qty-controls span {
        margin: 0 10px;
        font-size: 1rem;
    }

    .qty-controls button:hover {
        background-color: #4e724f;
    }

    .remove-btn {
        color: #999;
        cursor: pointer;
        font-size: 1rem;
        margin-left: 20px;
    }

    .remove-btn:hover {
        color: #405c45;
    }

    .cart-sidebar-footer {
        padding: 20px;
        border-top: 1px solid #ddd;
        display: flex;
        flex-direction: column;
        gap: 10px;
        /* Add spacing between elements */
    }

    .cart-total {
        display: flex;
        justify-content: space-between;
        font-size: 1.2rem;
        font-weight: bold;
        color: #405c45;
        margin-bottom: 10px;
        /* Add margin to separate from the button */
    }

    .checkout-btn {
        display: block;
        margin-top: 20px;
        width: 100%;
        padding: 10px;
        background-color: #405c45;
        color: #fff;
        text-align: center;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s;
    }

    .checkout-btn:hover {
        background-color: #4e724f;
    }
    </style>
</head>

<body>
    <?php include("../Components/staffnavbar.php"); ?>

    <?php while ($category_row = mysqli_fetch_assoc($category_result)) : ?>
    <div class="category-section">
        <div class="section-title"><?php echo $category_row['category']; ?></div>
        <div class="food-container">
            <?php
                // Fetch food items for the current category
                $current_category = $category_row['category'];
                $food_query = "SELECT * FROM menu WHERE category = '$current_category'";
                $food_result = mysqli_query($con, $food_query);

                // Display food items for the current category
                while ($row = mysqli_fetch_assoc($food_result)) :
                ?>
            <div class="food-item">
                <img src="<?php echo $row['image']; ?>" alt="<?php echo $row['name']; ?>">
                <div class="food-item-content">
                    <div class="food-details">
                        <div class="food-item-title"><?php echo $row['name']; ?></div>
                        <div class="food-item-description"><?php echo $row['description']; ?></div>
                    </div>
                    <div class="food-actions">
                        <div class="food-item-price">LKR <?php echo $row['price']; ?></div>
                        <a href="#" class="add-to-cart-btn">Add to Cart</a>
                    </div>
                </div>
            </div>
            <?php endwhile; ?>
        </div>
    </div>
    <?php endwhile; ?>


    <h2 class="section-heading" style="margin-bottom: 100px;">Enjoy our exclusive menu crafted with care and
        passion.
        Indulge in a delightful selection of dishes meticulously prepared to satisfy every craving.</h2>
    <!-- Your existing content -->


    <div class="my-cart-button">
        <a href="javascript:void(0);" onclick="toggleCart()" class="my-cart-icon btn btn-primary btn-lg">
            <i class="fas fa-shopping-cart"></i>
            <p>My Cart</p>
            <span id="cartNotification" class="cart-notification" style="display:none;"></span>
        </a>
    </div>

    <!-- Cart Sidebar -->
    <div id="cartSidebar" class="cart-sidebar">
        <div class="cart-sidebar-header">
            <h1>Your Basket</h1>
            <span class="close-cart" onclick="toggleCart()">&times;</span>
        </div>

        <div class="cart-sidebar-content" id="cartContent">
            <!-- Empty cart message -->
            <div id="emptyCartMessage" class="empty-cart-message"
                style="display: none; margin-top: 46px; size:12px; color:#999">
                Your basket looks a little empty. Why not check out some of our unbeatable deals?
            </div>
            <!-- Cart items will be dynamically added here -->

        </div>
        <div class="cart-sidebar-footer">
            <div class="cart-total">
                <span>Total:</span>
                <span id="cartTotal"></span>
            </div>
            <button id="checkoutBtn" class="checkout-btn">Checkout</button>
        </div>
    </div>

    <?php include("../Components/footer.php"); ?>



    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // Add event listeners to all add-to-cart buttons
        const addToCartButtons = document.querySelectorAll('.add-to-cart-btn');
        addToCartButtons.forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                addToCart(this);
            });
        });
    });

    function toggleCart() {
        const cartSidebar = document.getElementById('cartSidebar');
        if (cartSidebar) {
            cartSidebar.classList.toggle('active');
            updateCartTotal();
        }
    }

    function updateCartTotal() {
        const cartItems = document.querySelectorAll('.cart-item');
        const emptyCartMessage = document.getElementById('emptyCartMessage');
        const cartFooter = document.querySelector('.cart-sidebar-footer');
        let total = 0;
        let itemCount = cartItems.length; // Count the number of unique items

        cartItems.forEach(item => {
            const price = parseFloat(item.querySelector('.cart-item-price').getAttribute('data-price'));
            const qty = parseInt(item.querySelector('.qty-controls span').innerText);
            const itemTotal = price * qty;
            item.querySelector('.cart-item-total-price').innerText = `LKR ${itemTotal.toFixed(2)}`;
            total += itemTotal;
        });

        const cartTotal = document.getElementById('cartTotal');
        if (cartTotal) {
            cartTotal.innerText = `LKR ${total.toFixed(2)}`;
        }

        if (emptyCartMessage && cartFooter) {
            if (itemCount > 0) {
                emptyCartMessage.style.display = 'none';
                cartFooter.style.display = 'block';
            } else {
                emptyCartMessage.style.display = 'block';
                cartFooter.style.display = 'none';
            }
        }

        updateCartNotification(itemCount);
    }

    function increaseQty(button) {
        const qtySpan = button.previousElementSibling;
        let qty = parseInt(qtySpan.innerText);
        qtySpan.innerText = ++qty;
        updateCartTotal();
    }

    function decreaseQty(button) {
        const qtySpan = button.nextElementSibling;
        let qty = parseInt(qtySpan.innerText);
        if (qty > 1) {
            qtySpan.innerText = --qty;
            updateCartTotal();
        }
    }

    function removeItem(button) {
        const cartItem = button.closest('.cart-item');
        if (cartItem) {
            cartItem.remove();
            updateCartTotal();
        }
    }

    function addToCart(button) {
        const foodItem = button.closest('.food-item');
        const itemTitle = foodItem.querySelector('.food-item-title').innerText;
        const itemPrice = parseFloat(foodItem.querySelector('.food-item-price').innerText.replace('LKR', ''));
        const cartContent = document.querySelector('.cart-sidebar-content');

        // Check if the item already exists in the cart
        let existingItem = null;
        const cartItems = document.querySelectorAll('.cart-item');
        cartItems.forEach(item => {
            if (item.querySelector('.cart-item-title').innerText === itemTitle) {
                existingItem = item;
            }
        });

        if (existingItem) {
            // Increase quantity if item exists
            const qtySpan = existingItem.querySelector('.qty-controls span');
            let qty = parseInt(qtySpan.innerText);
            qtySpan.innerText = ++qty;
        } else {
            // Add new item to cart
            const cartItem = document.createElement('div');
            cartItem.classList.add('cart-item');
            cartItem.innerHTML = `
        <img src="${foodItem.querySelector('img').src}" alt="${itemTitle}" style="margin-top: 46px;">
        <div class="cart-item-details" style="margin-top: 46px;">
            <div class="cart-item-title">${itemTitle}</div>
            <div class="cart-item-price" data-price="${itemPrice}">LKR ${itemPrice.toFixed(2)}</div>
            <div class="cart-item-total-price">LKR ${itemPrice.toFixed(2)}</div>
        </div>
        <div class="qty-controls" style="margin-top: 46px;">
            <button onclick="decreaseQty(this)">-</button>
            <span>1</span>
            <button onclick="increaseQty(this)">+</button>
        </div>
        <div class="cart-item-remove" style="margin-top: 46px;">
            <span class="remove-btn" onclick="removeItem(this)">&times;</span>
        </div>
    `;
            cartContent.appendChild(cartItem);
        }
        updateCartTotal();
    }

    function updateCartNotification(count) {
        const cartNotification = document.getElementById('cartNotification');
        if (cartNotification) {
            if (count > 0) {
                cartNotification.innerText = count;
                cartNotification.style.display = 'block';
            } else {
                cartNotification.style.display = 'none';
            }
        }
    }
    document.getElementById('checkoutBtn').addEventListener('click', function(event) {
        event.preventDefault(); // Prevent default anchor tag behavior

        const cartItems = document.querySelectorAll('.cart-item');
        let cartData = [];

        cartItems.forEach(item => {
            const title = item.querySelector('.cart-item-title').innerText;
            const price = parseFloat(item.querySelector('.cart-item-price').getAttribute('data-price'));
            const quantity = parseInt(item.querySelector('.qty-controls span').innerText);

            cartData.push({
                title: title,
                price: price,
                quantity: quantity
            });
        });

        if (cartData.length > 0) {
            // Send the data to the server
            fetch('save_order.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        order: cartData
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        // Redirect to a success page or clear the cart
                        window.location.href = 'checkout_success.php';
                    } else {
                        alert('There was an error processing your order: ' + data.message);
                    }
                })
                .catch(error => console.error('Error:', error));
        } else {
            alert('Your cart is empty.');
        }
    });
    </script>
</body>

</html>
<?php
mysqli_close($con);
?>