<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';
$stmt = $conn->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Products</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Segoe UI', Tahoma, sans-serif;
      background: linear-gradient(to right, #f7f6f2, #e6f1ef);
      color: #2c2c2c;
      min-height: 100vh;
      padding: 60px 20px;
    }

    .container {
      background: #ffffff;
      max-width: 1100px;
      margin: auto;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.05);
    }

    h2 {
      text-align: center;
      font-size: 2.2rem;
      color: #1f2b2e;
      margin-bottom: 30px;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 30px;
    }

    th, td {
      padding: 14px 12px;
      text-align: left;
      border-bottom: 1px solid #ddd;
    }

    th {
      background-color: #3b5f5f;
      color: #fff;
      font-size: 0.9rem;
      text-transform: uppercase;
    }

    tr:nth-child(even) {
      background-color: #f8fdfa;
    }

    td img {
      width: 90px;
      height: auto;
      border-radius: 6px;
      box-shadow: 0 2px 6px rgba(0, 0, 0, 0.05);
    }

    .actions a {
      display: inline-block;
      margin: 2px 6px;
      padding: 8px 14px;
      border-radius: 6px;
      font-size: 0.85rem;
      font-weight: 500;
      text-decoration: none;
      color: #256d6d;
      border: 1px solid #256d6d;
      background-color: transparent;
      transition: all 0.3s ease;
    }

    .actions a:hover {
      background-color: #256d6d;
      color: #fff;
      transform: scale(1.05);
    }

    .btn-back {
      display: inline-block;
      text-align: center;
      padding: 12px 24px;
      font-size: 1rem;
      font-weight: 600;
      background: linear-gradient(to right, #4bb0a9, #2a807c);
      color: white;
      border: none;
      border-radius: 8px;
      text-decoration: none;
      transition: background 0.3s ease, transform 0.2s ease;
    }

    .btn-back:hover {
      transform: scale(1.05);
      background: linear-gradient(to right, #3ba89f, #1f6e6b);
    }

    @media (max-width: 768px) {
      th, td {
        font-size: 0.85rem;
        padding: 10px;
      }

      td img {
        width: 70px;
      }
    }
  </style>
</head>
<body>

<div class="container">
  <h2>Manage Products</h2>
  <table>
    <tr>
      <th>ID</th>
      <th>Name</th>
      <th>Price</th>
      <th>Description</th>
      <th>Image</th>
      <th>Actions</th>
    </tr>
    <?php foreach ($products as $product) : ?>
      <tr>
        <td><?= $product['id']; ?></td>
        <td><?= htmlspecialchars($product['name']); ?></td>
        <td>₹<?= number_format($product['price'], 2); ?></td>
        <td><?= htmlspecialchars($product['description']); ?></td>
        <td>
          <?php
          $fixedImagePath = str_replace('image/', 'images/', $product['image']);
          ?>
          <img src="/ecommerce/<?= htmlspecialchars($fixedImagePath); ?>" alt="Product Image">
        </td>
        <td class="actions">
          <a href="edit_product.php?id=<?= $product['id']; ?>">Edit</a>
          <a href="delete_product.php?id=<?= $product['id']; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
  <a href="dashboard.php" class="btn-back">← Back to Dashboard</a>
</div>

</body>
</html>
