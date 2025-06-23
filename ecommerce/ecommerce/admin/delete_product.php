<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.php");
    exit();
}

include '../includes/db.php';

// Check if product ID is provided
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Fetch product details to delete the image from the folder
    $stmt = $conn->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$product_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($product) {
        // Delete the image from the folder
        $image_path = "../" . $product['image'];
        if (file_exists($image_path)) {
            unlink($image_path);
        }

        // Prepare and execute the delete query
        $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
        $stmt->execute([$product_id]);

        // Redirect back to the manage products page
        header("Location: ../admin/manage_products.php");
        exit();
    } else {
        echo "Product not found!";
    }
} else {
    echo "Product ID not found!";
}
?>
