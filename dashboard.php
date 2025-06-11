<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit;
}
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
            <img src="https://profilepicsbucket.crossfit.com/athlete-avatar.jpg" alt="Athlete Avatar" class="profile-image">
            <a href="#" class="edit-photo-btn" title="Edit Photo">
            ✎
            </a>
        </div>
        <div class="profile-info">
            <h1 class="athlete-name">Ayumu Uehara</h1>
            <p class="join-date">Joined: Jun 10, 2025</p>
            <p class="cfid">FCID #2869153</p>
            <a href="/dashboard/profile" class="edit-profile-link">Edit Athlete Profile</a>
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