<?php
include 'connection.php';
session_start();

$admin_id = $_SESSION['admin_id'] ?? null;
if (!$admin_id) {
    header("Location: AdminAccess.php");
    exit();
}

// --- POST HANDLERS ---
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // UPDATE PRODUCT
    if (isset($_POST['action']) && $_POST['action'] === 'update') {
        $stmt = $con->prepare("UPDATE products SET product_name=?, product_details=?, price=?, quantity=?, category=? WHERE product_id=? AND admin_id=?");
        $stmt->bind_param("ssdisii", $_POST['product_name'], $_POST['product_details'], $_POST['price'], $_POST['quantity'], $_POST['category'], $_POST['product_id'], $admin_id);
        $stmt->execute();
        header("Location: productDetails.php");
        exit();
    }

    // DELETE PRODUCT
    if (isset($_POST['action']) && $_POST['action'] === 'delete') {
        $stmt = $con->prepare("DELETE FROM products WHERE product_id=? AND admin_id=?");
        $stmt->bind_param("ii", $_POST['product_id'], $admin_id);
        $stmt->execute();
        header("Location: productDetails.php");
        exit();
    }

    // ADD PRODUCT
    if (isset($_POST['action']) && $_POST['action'] === 'add') {
        $imageData = null;
        if (!empty($_FILES['product_image']['tmp_name'])) {
            $imageData = file_get_contents($_FILES['product_image']['tmp_name']);
        }

        $stmt = $con->prepare("INSERT INTO products (product_name, product_details, price, quantity, category, admin_id, product_image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssdisib", $_POST['product_name'], $_POST['product_details'], $_POST['price'], $_POST['quantity'], $_POST['category'], $admin_id, $imageData);
        $stmt->send_long_data(6, $imageData);
        $stmt->execute();
        header("Location: productDetails.php");
        exit();
    }

}

// --- FETCH PRODUCTS ---
$products = $con->query("SELECT * FROM products WHERE admin_id = $admin_id ORDER BY product_id DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Product Management</title>
  <link rel="stylesheet" href="./styles/adminpage.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php include 'admin-sidebar.php'; ?>

<div class="main-content">
  <div class="container py-4">
    <h2>Products</h2>

    <table class="table">
      <thead>
        <tr>
          <th>Name</th>
          <th>Details</th>
          <th>Price (₱)</th>
          <th>Quantity</th>
          <th>Category</th>
          <th>Modify</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $products->fetch_assoc()): ?>
          <?php if (isset($_GET['edit']) && $_GET['edit'] == $row['product_id']): ?>
            <tr>
              <form method="POST">
                <td><input type="text" name="product_name" value="<?= htmlspecialchars($row['product_name']) ?>" class="form-control" required></td>
                <td><textarea name="product_details" class="form-control" required><?= htmlspecialchars($row['product_details']) ?></textarea></td>
                <td><input type="number" name="price" value="<?= $row['price'] ?>" step="0.01" class="form-control" required></td>
                <td><input type="number" name="quantity" value="<?= $row['quantity'] ?>" class="form-control" required></td>
                <td><input type="text" name="category" value="<?= htmlspecialchars($row['category']) ?>" class="form-control" required></td>
                <td>
                  <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                  <input type="hidden" name="action" value="update">
                  <button class="btn btn-success btn-sm">Save</button>
                  <a href="productDetails.php" class="btn btn-secondary btn-sm">Cancel</a>
                </td>
              </form>
            </tr>
          <?php else: ?>
            <tr>
              <td><?= htmlspecialchars($row['product_name']) ?></td>
              <td><?= nl2br(htmlspecialchars($row['product_details'])) ?></td>
              <td><?= number_format($row['price'], 2) ?></td>
              <td><?= $row['quantity'] ?></td>
              <td><?= htmlspecialchars($row['category']) ?></td>
              <td>
                <a href="productDetails.php?edit=<?= $row['product_id'] ?>" class="btn btn-outline-light btn-sm">Update</a>
                <form method="POST" style="display:inline;">
                  <input type="hidden" name="product_id" value="<?= $row['product_id'] ?>">
                  <input type="hidden" name="action" value="delete">
                  <button class="btn btn-outline-light btn-sm" onclick="return confirm('Delete this product?')">Delete</button>
                </form>
              </td>
            </tr>
          <?php endif; ?>
        <?php endwhile; ?>
      </tbody>
    </table>

    <!-- Add Product -->
    <form method="POST" class="mt-4" enctype="multipart/form-data">
      <h4>Add New Product</h4>
      <div class="d-flex flex-wrap gap-3 justify-content-between">
        <input class="form-control flex-fill" style="min-width:180px" name="product_name" placeholder="Product Name" required>
        <textarea class="form-control flex-fill" style="min-width:200px" name="product_details" placeholder="Product Details" required></textarea>
        <input class="form-control" style="width:140px" name="price" placeholder="Price" type="number" step="0.01" required>
        <input class="form-control" style="width:140px" name="quantity" placeholder="Quantity" type="number" required>
        <input class="form-control" style="min-width:180px" name="category" placeholder="Category" required>
        <input type="file" name="product_image" accept="image/*" class="form-control" style="min-width:200px">
        <input type="hidden" name="action" value="add">
        <button class="btn btn-dark w-100" style="max-width:140px">Add Product</button>
      </div>
    </form>

  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
