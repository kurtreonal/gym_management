<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit;
}

$user_id = $_SESSION['user_id'];

$stmt = $con->prepare("SELECT first_name, last_name, created_date, fcid, profile_image FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$full_name = $user['first_name'] . ' ' . $user['last_name'];
$created_date = date("M d, Y", strtotime($user['created_date']));
$fcid = $user['fcid'] ?? 'Not Assigned';
$profile_image = $user['profile_image'] ? 'data:image/jpeg;base64,' . base64_encode($user['profile_image']) : 'https://profilepicsbucket.crossfit.com/athlete-avatar.jpg';
?>


<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sidebar Menu</title>
  <link rel="stylesheet" href="./styles/dashboard.css">
</head>
<body>
    <?php
    include 'sidebar.php';
    ?>
    <div class="main-content">
    <div class="container">
    <h1 style="margin-bottom: 5%;border-bottom: 1px solid #333;">DASHBOARD</h1>
    <!-- Profile Header -->
    <div class="profile-header">
    <div class="profile-left">
        <div class="profile-image-wrapper">
        <img src="<?= $profile_image ?>" alt="Athlete Avatar" class="profile-image">
        <a href="#" class="edit-photo-btn" title="Edit Photo">✎</a>
        </div>
        <div class="profile-info">
        <h1 class="athlete-name"><?= htmlspecialchars($full_name) ?></h1>
        <p class="join-date">Joined: <?= $created_date ?></p>
        <p class="cfid">FCID #<?= htmlspecialchars($fcid) ?></p>
        <a href="account_settings.php" class="edit-profile-link">Edit Athlete Profile</a>
        </div>
    </div>
    </div>


    <!-- Dashboard Grid -->
    <div class="dashboard-grid">
        <div class="dashboard-card">
            <h2>Membership Plans</h2>
            <p>Get Access to our gym equipment and get your official FCID pass</p>
            <a href="">button</a>
        </div>
    </div>
    </div>
    </div>

        <script src="./script/test.js"></script>
</body>
</html>