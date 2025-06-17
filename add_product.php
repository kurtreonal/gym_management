<?php
include 'connection.php';
session_start();

$admin_id = $_SESSION['admin_id'] ?? null;
if (!$admin_id) {
    header("Location: AdminAccess.php"); exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_name    = $_POST['product_name'];
    $product_details = $_POST['product_details'];
    $price           = $_POST['price'];
    $quantity        = $_POST['quantity'];
    $category        = $_POST['category'];

    $image_data = null;
    if (isset($_FILES['image']) && $_FILES['image']['tmp_name']) {
        $image_data = file_get_contents($_FILES['image']['tmp_name']);
    }

    $stmt = $con->prepare(
        "INSERT INTO products (product_name, product_details, price, quantity, admin_id, category, image)
         VALUES (?, ?, ?, ?, ?, ?, ?)"
    );
    $stmt->bind_param("ssdiisb", $product_name, $product_details, $price, $quantity, $admin_id, $category, $null);
    $null = NULL;

    if ($image_data) {
        $stmt->send_long_data(6, $image_data);
    }

    $stmt->execute();
    header("Location: productDetails.php");
    exit();
}
?>
