<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

$user_id = $_SESSION['user_id'];

// Add to cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = isset($_POST['quantity']) ? (int)$_POST['quantity'] : 1;

    $stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    $cart_item = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($cart_item) {
        $new_quantity = $cart_item['quantity'] + $quantity;
        $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$new_quantity, $user_id, $product_id]);
    } else {
        $stmt = $conn->prepare("INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $quantity]);
    }
}

// Remove from cart
if (isset($_POST['remove_from_cart'])) {
    $product_id = $_POST['product_id'];
    $stmt = $conn->prepare("DELETE FROM cart WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
}

// Update quantity
if (isset($_POST['update_quantity'])) {
    $product_id = $_POST['product_id'];
    $quantity = (int)$_POST['quantity'];

    $stmt = $conn->prepare("UPDATE cart SET quantity = ? WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$quantity, $user_id, $product_id]);
}

// Get cart items
$stmt = $conn->prepare("SELECT * FROM cart WHERE user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

$total_cost = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(to right, #dbeafe, #eff6ff); /* Elegant blue background */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            background: #ffffff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 8px 20px rgba(0,0,0,0.05);
        }
        h2 {
            text-align: center;
            font-weight: 700;
            color: #333;
            margin-bottom: 30px;
        }
        .cart-item {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #e5e7eb;
        }
        .cart-item img {
            width: 90px;
            height: auto;
            margin-right: 20px;
            border-radius: 8px;
        }
        .item-details {
            flex-grow: 1;
        }
        .item-name {
            font-size: 1.1em;
            font-weight: 600;
        }
        .item-price {
            color: #666;
            margin-top: 5px;
        }
        .item-actions {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .item-actions form {
            display: flex;
            gap: 6px;
        }
        .item-actions input[type="number"] {
            width: 60px;
            padding: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        .item-actions button {
            padding: 6px 10px;
            background: #1d4ed8;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            transition: background 0.3s ease;
        }
        .item-actions button:hover {
            background: #2563eb;
        }
        .remove-btn {
            background: #dc2626;
        }
        .remove-btn:hover {
            background: #b91c1c;
        }
        .total-cost {
            text-align: center;
            font-size: 1.3em;
            font-weight: 600;
            margin-top: 30px;
        }
        .cart-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }
        .cart-actions a {
            padding: 12px 24px;
            background: #10b981;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background 0.3s ease;
        }
        .cart-actions a:hover {
            background: #059669;
        }
        .empty-cart {
            text-align: center;
            font-size: 1.1em;
            color: #777;
        }
        @media (max-width: 600px) {
            .cart-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .item-actions {
                flex-direction: row;
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Your Cart</h2>
        <?php if (empty($cart_items)) : ?>
            <p class="empty-cart">Your cart is empty.</p>
        <?php else : ?>
            <?php
            $product_ids = array_column($cart_items, 'product_id');
            $placeholders = implode(',', array_fill(0, count($product_ids), '?'));
            $stmt = $conn->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
            $stmt->execute($product_ids);
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($products as $product) {
                foreach ($cart_items as $item) {
                    if ($item['product_id'] == $product['id']) {
                        $quantity = $item['quantity'];
                        break;
                    }
                }

                $total_cost += $product['price'] * $quantity;
                echo "
                <div class='cart-item'>
                    <img src='../{$product['image']}' alt='{$product['name']}'>
                    <div class='item-details'>
                        <div class='item-name'>{$product['name']}</div>
                        <div class='item-price'>₹" . number_format($product['price'], 2) . " × $quantity</div>
                    </div>
                    <div class='item-actions'>
                        <form method='POST'>
                            <input type='hidden' name='product_id' value='{$product['id']}'>
                            <input type='number' name='quantity' value='$quantity' min='1'>
                            <button type='submit' name='update_quantity'>Update</button>
                        </form>
                        <form method='POST'>
                            <input type='hidden' name='product_id' value='{$product['id']}'>
                            <button class='remove-btn' type='submit' name='remove_from_cart'>Remove</button>
                        </form>
                    </div>
                </div>";
            }
            ?>
            <div class="total-cost">Total: ₹<?= number_format($total_cost, 2); ?></div>
        <?php endif; ?>
        <div class="cart-actions">
            <a href='index.php'>← Back to Shop</a>
            <a href='checkout.php'>Proceed to Checkout →</a>
        </div>
    </div>
</body>
</html>

