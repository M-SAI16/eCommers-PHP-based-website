<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <style>
        /* Reset and base styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #00b894, #8e44ad);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.9);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        .container {
            width: 90%;
            max-width: 600px;
            margin: 80px auto 40px;
            background-color: #ffffff;
            padding: 50px 30px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.08);
            text-align: center;
            animation: zoomIn 0.6s ease-out;
        }

        h2 {
            font-size: 2.5rem;
            margin-bottom: 40px;
            color: #2c3e50;
            letter-spacing: 1px;
            animation: zoomIn 0.6s ease-out;
        }

        nav {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        nav a {
            display: inline-block;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 600;
            padding: 14px 24px;
            border-radius: 10px;
            color: white;
            transition: all 0.3s ease-in-out;
            animation: zoomIn 0.6s ease-out;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        nav a:nth-child(1) {
            background-image: linear-gradient(to right, #6a11cb, #2575fc); /* Purple to blue */
        }

        nav a:nth-child(1):hover {
            transform: scale(1.08);
            box-shadow: 0 10px 25px rgba(55, 157, 164, 0.3);
        }

        nav a:nth-child(2) {
            background-image: linear-gradient(to right, #00c9ff, #92fe9d); /* Cyan to green */
        }

        nav a:nth-child(2):hover {
            transform: scale(1.08);
            box-shadow: 0 10px 25px rgba(0, 201, 255, 0.3);
        }

        nav a.logout {
            background-image: linear-gradient(to right, #ff758c, #ff7eb3); /* Light rose tones */
        }

        nav a.logout:hover {
            transform: scale(1.08);
            box-shadow: 0 10px 25px rgba(255, 65, 108, 0.4);
        }

        footer {
            text-align: center;
            font-size: 0.95rem;
            color: rgba(255, 255, 255, 0.7);
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }

            nav a {
                font-size: 1rem;
                padding: 12px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Admin Dashboard</h2>
        <nav>
            <a href="add_product.php">Add Product</a>
            <a href="manage_products.php">Manage Products</a>
            <a href="logout.php" class="logout">Logout</a>
        </nav>
    </div>
    <footer>
        <p>&copy; <?php echo date("Y"); ?> Admin Dashboard</p>
    </footer>
</body>
</html>



