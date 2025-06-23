<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}
?>

<?php
include '../includes/db.php';

if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];

    $imageName = basename($_FILES['image']['name']);
    $imagePathInDB = "images/" . $imageName;
    $uploadPath = "../images/" . $imageName;

    if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
        $stmt = $conn->prepare("INSERT INTO products (name, price, description, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $price, $description, $imagePathInDB]);

        echo "<p style='color:green; text-align:center;'>Product added successfully!</p>";
    } else {
        echo "<p style='color:red; text-align:center;'>Failed to upload image.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Add Product</title>
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #f6d365, #fda085);
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 60px auto;
            background-color: #ffffff;
            border-radius: 16px;
            padding: 40px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.1);
            animation: zoomIn 0.5s ease;
        }

        @keyframes zoomIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            font-size: 2rem;
            margin-bottom: 30px;
        }

        form label {
            font-weight: 600;
            margin-bottom: 6px;
            display: block;
            color: #333;
        }

        form input[type="text"],
        form input[type="number"],
        form textarea,
        form input[type="file"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        form input:focus,
        form textarea:focus {
            outline: none;
            border-color: #a29bfe;
        }

        button[type="submit"] {
            background-image: linear-gradient(to right, #43cea2, #185a9d);
            color: white;
            padding: 14px;
            font-size: 1.1rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        button[type="submit"]:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(67, 206, 162, 0.4);
        }

        .back-link {
            text-align: center;
            margin-top: 25px;
        }

        .back-link a {
            text-decoration: none;
            color: #2980b9;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .back-link a:hover {
            color: #1abc9c;
        }

        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
                margin: 30px 10px;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Add Product</h2>
        <form method="POST" enctype="multipart/form-data">
            <label for="name">Product Name:</label>
            <input type="text" name="name" id="name" required>

            <label for="price">Price:</label>
            <input type="number" step="0.01" name="price" id="price" required>

            <label for="description">Description:</label>
            <textarea name="description" id="description" rows="5" required></textarea>

            <label for="image">Product Image:</label>
            <input type="file" name="image" id="image" accept="image/*" required>

            <button type="submit" name="add_product">Add Product</button>
        </form>
        <div class="back-link">
            <a href="manage_products.php">← Back to Manage Products</a>
        </div>
    </div>
</body>
</html>



