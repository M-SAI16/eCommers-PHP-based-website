<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "Product not found!";
        exit();
    }

    if (isset($_POST['edit_product'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];
        $description = $_POST['description'];

        if ($_FILES['image']['name']) {
            $image = $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "../images/$image");
        } else {
            $image = $product['image'];
        }

        $stmt = $conn->prepare("UPDATE products SET name = ?, price = ?, description = ?, image = ? WHERE id = ?");
        $stmt->execute([$name, $price, $description, $image, $product_id]);

        header("Location: ../admin/manage_products.php");
        exit();
    }
} else {
    echo "Product ID not found!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Edit Product</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      padding: 60px 0;
      background: linear-gradient(to right, #e8dad1, #f2e9e4);
    }

    .container {
      max-width: 600px;
      margin: auto;
      background-color: #ffffff;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    h2 {
     text-align: center;
     margin-bottom: 30px;
     font-size: 28px;
     font-weight: 700;
     color: #6d6875;
     text-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
    }


    form {
      display: flex;
      flex-direction: column;
    }

    label {
      margin-bottom: 6px;
      font-weight: 600;
      color: #4b3832;
    }

    input[type="text"],
    input[type="number"],
    textarea {
      padding: 12px;
      border: 1px solid #ccc;
      border-radius: 6px;
      margin-bottom: 20px;
      font-size: 15px;
    }

    input[type="file"] {
      margin-bottom: 20px;
    }

    .current-image {
      margin-bottom: 20px;
    }

    .current-image img {
      width: 120px;
      height: auto;
      border-radius: 6px;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    button {
      background: linear-gradient(to right, #b5838d, #6d6875);
      color: white;
      padding: 14px;
      border: none;
      border-radius: 6px;
      font-size: 16px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background: linear-gradient(to right, #6d6875, #b5838d);
    }

    .back-link {
      text-align: center;
      margin-top: 25px;
    }

    .back-link a {
      text-decoration: none;
      color: #6d6875;
      font-weight: 500;
    }

    .back-link a:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <div class="container">
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
      <label for="name">Product Name:</label>
      <input type="text" name="name" id="name" value="<?= htmlspecialchars($product['name']); ?>" required>

      <label for="price">Price:</label>
      <input type="number" step="0.01" name="price" id="price" value="<?= htmlspecialchars($product['price']); ?>" required>

      <label for="description">Description:</label>
      <textarea name="description" id="description" required><?= htmlspecialchars($product['description']); ?></textarea>

      <label for="image">Image:</label>
      <input type="file" name="image" id="image">
      <div class="current-image">
        <small>Current Image:</small><br>
        <img src="../<?= htmlspecialchars($product['image']); ?>" alt="Current Product Image">
      </div>

      <button type="submit" name="edit_product">Update Product</button>
    </form>
    <div class="back-link">
      <a href="manage_products.php">← Back to Manage Products</a>
    </div>
  </div>
</body>
</html>
