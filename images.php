<?php
include 'connection.php';
session_start();
$admin_id = $_SESSION['admin_id'] ?? null;
if (!$admin_id) {
    header("Location: AdminAccess.php"); exit();
}

$error = ""; //store error messages

//Handle Upload
if (isset($_POST['upload']) && isset($_POST['image_type'])) {
    $file = $_FILES['image_file'];
    $image_type = $_POST['image_type'];

    $allowed = ['jpg','jpeg','png','gif','webp'];
    $ext = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

    if (in_array($ext, $allowed) && $file['size'] <= 3 * 1024 * 1024) {
        $filename = uniqid('img_', true).".".$ext;
        $dest = __DIR__ . '/assets/' . $filename;
        if (move_uploaded_file($file['tmp_name'], $dest)) {
            $stmt = $con->prepare("INSERT INTO Images (image_name, image_type) VALUES (?, ?)");
            $stmt->bind_param("ss", $filename, $image_type);
            $stmt->execute();
        } else {
            $error = "Failed to save file.";
        }
    } else {
        $error = "Invalid or too large file.";
    }
}

// Handle Delete
if (isset($_POST['delete']) && isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $stmt = $con->prepare("SELECT image_name FROM Images WHERE images_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $row = $stmt->get_result()->fetch_assoc();
    if ($row) {
        $path = __DIR__ . '/assets/' . $row['image_name'];
        if (file_exists($path)) unlink($path);
    }
    $stmt = $con->prepare("DELETE FROM Images WHERE images_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
}

// Fetch images by type
$bgImages = $con->query("SELECT * FROM Images WHERE image_type = 'background' ORDER BY images_id DESC")->fetch_all(MYSQLI_ASSOC);
$methodImages = $con->query("SELECT * FROM Images WHERE image_type = 'ourmethod' ORDER BY images_id DESC")->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <title>Manage Images</title>
  <link rel="stylesheet" href="./styles/adminpage.css">
  <style>
    .img-grid { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 15px; }
    .img-item { position: relative; width: 150px; }
    .img-item img { width: 100%; height: auto; border: 1px solid #ccc; }
    .img-item form { position: absolute; top: 5px; right: 5px; }
    .img-item button { background: rgba(255,0,0,0.7); color: #fff; border: none; padding: 2px 5px; cursor: pointer; }
    .change-btn { padding: 8px 16px; background: #333; color: #fff; border: none; border-radius: 4px; cursor: pointer; margin-top: 10px; }
    h2 { margin-top: 30px; }
  </style>
</head>
<body>
  <?php include 'admin-sidebar.php'; ?>
  <div class="main-content">
    <div class="container">
      <h1>Image Management</h1>
      <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

      <!-- Background Images -->
      <h2 style="color: gold;border-bottom: solid 1px;">Background Images</h2>
      <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image_file" accept="image/*" required>
        <input type="hidden" name="image_type" value="background">
        <button name="upload" class="change-btn">Add Background Image</button>
      </form>
      <div class="img-grid">
        <?php foreach ($bgImages as $img): ?>
          <div class="img-item">
            <img src="assets/<?= htmlspecialchars($img['image_name']) ?>" alt="BG Image">
            <form method="POST" onsubmit="return confirm('Delete this image?');">
              <input type="hidden" name="id" value="<?= $img['images_id'] ?>">
              <button name="delete">×</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Our Method Images -->
      <h2 style="color: gold;border-bottom: solid 1px;">Our Method Images</h2>
      <form method="POST" enctype="multipart/form-data">
        <input type="file" name="image_file" accept="image/*" required>
        <input type="hidden" name="image_type" value="ourmethod">
        <button name="upload" class="change-btn">Add Our Method Image</button>
      </form>
      <div class="img-grid">
        <?php foreach ($methodImages as $img): ?>
          <div class="img-item">
            <img src="assets/<?= htmlspecialchars($img['image_name']) ?>" alt="Method Image">
            <form method="POST" onsubmit="return confirm('Delete this image?');">
              <input type="hidden" name="id" value="<?= $img['images_id'] ?>">
              <button name="delete">×</button>
            </form>
          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>
</body>
</html>
