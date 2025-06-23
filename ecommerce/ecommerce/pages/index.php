<?php
session_start();
include '../includes/db.php';

// Fetch products from the database
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechNest Store</title>
    <style>
        body {
            background: #f4f4f9;
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #2c3e50;
            color: #fff;
            padding: 20px 0;
        }

        .header-container {
            max-width: 1200px;
            margin: auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            padding: 0 20px;
        }

        .header-container h1 {
            font-size: 2rem;
            background: linear-gradient(90deg, #d38312, #a83279);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        nav a {
            margin-left: 20px;
            color: #f1c40f;
            text-decoration: none;
            font-weight: 500;
        }

        nav a:hover {
            text-decoration: underline;
        }

        .main-container {
            max-width: 1200px;
            margin: 40px auto;
            padding: 0 20px;
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .filter-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }

        #searchInput, #categoryFilter {
            padding: 12px 18px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.08);
        }

        #searchInput:focus, #categoryFilter:focus {
            outline: none;
            border-color: #a83279;
            box-shadow: 0 0 8px rgba(168, 50, 121, 0.3);
        }

        .product-list {
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
            justify-content: center;
        }

        .product {
            background-color: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.08);
            padding: 20px;
            width: 280px;
            transition: transform 0.3s, box-shadow 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }

        .product:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0,0,0,0.15);
        }

        .product h3 {
            margin-bottom: 10px;
            font-size: 18px;
            color: #333;
        }

        .product p {
            font-size: 15px;
            color: #555;
            margin-bottom: 10px;
        }

        .product-image {
            width: 100%;
            height: 180px;
            object-fit: contain;
            margin-bottom: 10px;
            border-radius: 8px;
            background-color: #fff;
        }

        .add-to-cart-button {
            background-color: #a83279;
            color: white;
            border: none;
            padding: 10px 16px;
            border-radius: 6px;
            font-size: 14px;
            cursor: pointer;
            transition: background 0.3s;
        }

        .add-to-cart-button:hover {
            background-color: #8e2d65;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-container">
            <h1>Welcome to TechNest</h1>
            <nav>
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
                <a href="cart.php" class="cart-link">
                    <img src="../images/cart-icon.png" alt="Cart" class="cart-icon" style="width: 18px; vertical-align: middle;">
                    Cart
                </a>
                <a href="logout.php" class="logout-button">Logout</a>
            </nav>
        </div>
    </header>

    <div class="main-container">
        <h2>Explore Our Products</h2>

        <!-- Search & Category Filters -->
        <div class="filter-container">
            <input type="text" id="searchInput" placeholder="Search for products...">
            <select id="categoryFilter">
                <option value="all">All Categories</option>
                <option value="phones">Phones</option>
                <option value="laptops">Laptops</option>
            </select>
        </div>

        <!-- Product List -->
        <div class="product-list">
            <?php if (empty($products)) : ?>
                <p>No products available.</p>
            <?php else : ?>
                <?php foreach ($products as $product) : ?>
                    <div class="product" data-category="<?= htmlspecialchars($product['category']); ?>">
                        <h3><?= htmlspecialchars($product['name']); ?></h3>
                        <p>Price: ₹<?= number_format($product['price'], 2); ?></p>
                        <p><?= htmlspecialchars($product['description']); ?></p>
                        <?php if (!empty($product['image'])) : ?>
                            <img src="../<?= htmlspecialchars($product['image']); ?>" alt="<?= htmlspecialchars($product['name']); ?>" class="product-image">
                        <?php endif; ?>
                        <form method="POST" action="cart.php">
                            <input type="hidden" name="product_id" value="<?= $product['id']; ?>">
                            <button type="submit" name="add_to_cart" class="add-to-cart-button">Add to Cart</button>
                        </form>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script>
        const searchInput = document.getElementById("searchInput");
        const categoryFilter = document.getElementById("categoryFilter");
        const products = document.querySelectorAll(".product");

        function filterProducts() {
            const query = searchInput.value.toLowerCase();
            const selectedCategory = categoryFilter.value;

            products.forEach(product => {
                const text = product.innerText.toLowerCase();
                const category = product.getAttribute("data-category");

                const matchesSearch = text.includes(query);
                const matchesCategory = selectedCategory === "all" || category === selectedCategory;

                product.style.display = matchesSearch && matchesCategory ? "flex" : "none";
            });
        }

        searchInput.addEventListener("keyup", filterProducts);
        categoryFilter.addEventListener("change", filterProducts);
    </script>
</body>
</html>
