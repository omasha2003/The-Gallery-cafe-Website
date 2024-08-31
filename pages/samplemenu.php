<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Gallery Café</title>
    <link rel="icon" type="image" href="../Images/Icon.png">
    <style>
        /* Embedded CSS for The Gallery Café Menu Page */
        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin-top: 80px; /* Header height (50px) + Categories container height (80px) */
            padding: 0;
        }

        .categories-container {
            display: flex;
            justify-content: space-around;
            position: fixed;
            top: 50px; /* Positioned below the header */
            width: 100%;
            background-color: white; /* Make the background transparent */
            padding: 10px 0;
            z-index: 1000; /* Ensure it stays above other elements */
            border-bottom: none; /* Remove the bottom border */
            border-top: 2px solid black;
        }

        .category-icon {
            display: flex;
            flex-direction: column;
            align-items: center;
            background-color: transparent; /* Ensure individual icons also have transparent background */
            cursor: pointer; /* Added cursor pointer for better UX */
        }

        .category-icon img {
            width: 50px; /* Adjust size as needed */
            height: auto;
        }

        .category-icon p {
            margin-top: 5px; /* Adjust spacing as needed */
        }

        .menu-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            padding-top: 80px; /* Adjust padding to avoid overlap with the fixed categories */
        }

        .menu-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .category-filter, .search-input {
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .menu-items {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }

        .category {
            width: 100%;
            margin-bottom: 40px;
        }

        .category h2 {
            font-size: 24px;
            margin-bottom: 20px;
            border-bottom: 2px solid #200e68; /* A border for better distinction */
            padding-bottom: 10px;
            color: #200e68; /* Matching color to the button for consistency */
        }

        .category-item {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            border-radius: 10px;
            overflow: hidden;
            width: 100%;
            max-width: 600px;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Added shadow for better appearance */
        }

        .category-item img {
            width: 200px;
            height: 150px;
            object-fit: cover;
            margin-right: 20px;
        }

        .category-item-info {
            padding: 20px;
        }

        .category-item-info h3 {
            font-size: 20px;
            margin-bottom: 10px;
        }

        .category-item-description {
            font-size: 14px;
            color: #666;
            margin-bottom: 10px;
        }

        .category-item-price {
            font-size: 18px;
            color: #000;
            margin-bottom: 10px;
        }

        .add-to-cart-btn {
            padding: 10px 20px;
            background-color: #200e68;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .add-to-cart-btn:hover {
            background-color: #0e0f49;
        }

        .cart-button {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background-color: #ffffff;
            border-radius: 50%;
            width: 60px;
            height: 60px;
            display: flex;
            justify-content: center;
            align-items: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            cursor: pointer;
        }

        .cart-button img {
            width: 50px;
            height: 50px;
        }

        .cart-count {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px;
            font-size: 12px;
            width: 25px;
            height: 25px;
            display: flex;
            justify-content: center;
            align-items: center;
            border: 2px solid #fff;
            font-weight: bold;
        }

        .cart-modal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            justify-content: center;
            align-items: center;
            z-index: 1000;
        }

        .cart-modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            max-height: 80%; /* Limit the height */
            overflow-y: auto; /* Allow vertical scrolling */
        }

        .cart-modal .close {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
        }

        .cart-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 1000;
        }

        .cart-overlay.open {
            display: flex;
        }

        .cart-content {
            background-color: white;
            padding: 20px;
            border-radius: 10px;
            width: 80%;
            max-width: 600px;
            max-height: 80%; /* Limit the height */
            overflow-y: auto; /* Allow vertical scrolling */
        }

        .close-cart {
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 24px;
            cursor: pointer;
        }

        .cart-items {
            margin-bottom: 20px;
        }

        .cart-item {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
        }

        .cart-item img {
            width: 80px;
            height: 80px;
            object-fit: cover;
            margin-right: 10px;
        }

        .cart-item-info {
            flex: 1;
        }

        .cart-item-controls {
            display: flex;
            align-items: center;
        }

        .cart-item-controls button {
            padding: 5px;
            font-size: 14px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin: 0 5px;
        }

        .cart-item-controls button:hover {
            background-color: #555;
        }

        .cart-item-controls input {
            width: 40px;
            text-align: center;
            border: 1px solid #ddd;
            border-radius: 5px;
            padding: 5px;
        }

        .delete-button {
            background-color: red;
            margin-left: 10px;
        }

        .cart-total {
            font-size: 18px;
            font-weight: bold;
            text-align: right;
        }

        .checkout-button {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            background-color: #333;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .checkout-button:hover {
            background-color: #555;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>

<div class="categories-container">
    <div class="category-icon" onclick="filterCategory('Sri Lankan')">
        <img src="../Images/srilankan.png" alt="Sri Lankan">
        <p>Sri Lankan</p>
    </div>
    <div class="category-icon" onclick="filterCategory('Chinese')">
        <img src="../Images/chinese.png" alt="Chinese">
        <p>Chinese</p>
    </div>
    <div class="category-icon" onclick="filterCategory('Italian')">
        <img src="../Images/italian.png" alt="Italian">
        <p>Italian</p>
    </div>
    <div class="category-icon" onclick="filterCategory('Indian')">
        <img src="../Images/indian.png" alt="Indian">
        <p>Indian</p>
    </div>
</div>

<div class="menu-container">
    <div class="menu-header">
        <input type="text" class="search-input" placeholder="Search...">
        <select class="category-filter" onchange="filterCategory(this.value)">
            <option value="">All Categories</option>
            <option value="Sri Lankan">Sri Lankan</option>
            <option value="Chinese">Chinese</option>
            <option value="Italian">Italian</option>
            <option value="Indian">Indian</option>
        </select>
    </div>
    
    <div class="menu-items">
        <!-- Example Category Item -->
        <div class="category">
            <h2>Sri Lankan Dishes</h2>
            <div class="category-item">
                <img src="../Images/dish1.jpg" alt="Dish 1">
                <div class="category-item-info">
                    <h3>Dish 1</h3>
                    <p class="category-item-description">Delicious Sri Lankan dish with a blend of spices.</p>
                    <p class="category-item-price">$10.00</p>
                    <button class="add-to-cart-btn" onclick="addToCart('Dish 1')">Add to Cart</button>
                </div>
            </div>
            <!-- Add more category items as needed -->
        </div>
    </div>
</div>

<!-- Cart Button -->
<div class="cart-button" onclick="toggleCart()">
    <img src="../Images/cart.png" alt="Cart">
    <div class="cart-count" id="cart-count">0</div>
</div>

<!-- Cart Modal -->
<div class="cart-overlay" id="cart-overlay">
    <div class="cart-content">
        <span class="close-cart" onclick="closeCart()">&times;</span>
        <h2>Your Cart</h2>
        <div class="cart-items" id="cart-items">
            <!-- Cart items will be dynamically added here -->
        </div>
        <div class="cart-total" id="cart-total">Total: $0.00</div>
        <button class="checkout-button" onclick="checkout()">Checkout</button>
    </div>
</div>

<script>
    let cart = [];
    
    function filterCategory(category) {
        // Implement category filtering logic here
        console.log(`Filtering by category: ${category}`);
    }

    function addToCart(itemName) {
        // Example item addition logic
        const item = { name: itemName, price: 10.00 }; // Example price
        cart.push(item);
        updateCart();
    }

    function updateCart() {
        const cartItemsDiv = document.getElementById('cart-items');
        const cartTotalDiv = document.getElementById('cart-total');
        const cartCountDiv = document.getElementById('cart-count');
        
        cartItemsDiv.innerHTML = '';
        let total = 0;
        
        cart.forEach((item, index) => {
            const cartItemDiv = document.createElement('div');
            cartItemDiv.className = 'cart-item';
            
            cartItemDiv.innerHTML = `
                <img src="../Images/dish1.jpg" alt="${item.name}">
                <div class="cart-item-info">
                    <p>${item.name}</p>
                    <p>$${item.price.toFixed(2)}</p>
                </div>
                <div class="cart-item-controls">
                    <button onclick="removeFromCart(${index})">Remove</button>
                </div>
            `;
            
            cartItemsDiv.appendChild(cartItemDiv);
            total += item.price;
        });
        
        cartTotalDiv.innerText = `Total: $${total.toFixed(2)}`;
        cartCountDiv.innerText = cart.length;
    }

    function removeFromCart(index) {
        cart.splice(index, 1);
        updateCart();
    }

    function toggleCart() {
        const cartOverlay = document.getElementById('cart-overlay');
        cartOverlay.classList.toggle('open');
    }

    function closeCart() {
        const cartOverlay = document.getElementById('cart-overlay');
        cartOverlay.classList.remove('open');
    }

    function checkout() {
        // Implement checkout logic here
        alert('Proceeding to checkout');
    }
</script>

</body>
</html>
