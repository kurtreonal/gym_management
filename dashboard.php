<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Handle cancel membership action
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['cancel_membership'])) {
    $cancelStmt = $con->prepare("UPDATE users SET membership_id = NULL, validation_date = NULL, expiry_date = NULL WHERE user_id = ?");
    $cancelStmt->bind_param("i", $user_id);
    $cancelStmt->execute();
    header("Location: dashboard.php");
    exit;
}

// Get user info
$stmt = $con->prepare("SELECT first_name, last_name, created_date, fcid, profile_image, membership_id, validation_date, expiry_date FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

$full_name = $user['first_name'] . ' ' . $user['last_name'];
$created_date = date("M d, Y", strtotime($user['created_date']));
$fcid = $user['fcid'] ?? 'Not Assigned';
$profile_image = $user['profile_image'] ? 'data:image/jpeg;base64,' . base64_encode($user['profile_image']) : 'https://profilepicsbucket.crossfit.com/athlete-avatar.jpg';

// Fetch membership details
$membership_validity = "";
if (!empty($user['membership_id'])) {
    $stmt = $con->prepare("
        SELECT plan_name, duration_days
        FROM membership_plan
        WHERE membership_id = ?
    ");
    $stmt->bind_param("i", $user['membership_id']);
    $stmt->execute();
    $result = $stmt->get_result()->fetch_assoc();

    if ($result) {
        $validation_date = $user['validation_date'] ?? $user['created_date'];
        $expiry_date = $user['expiry_date'] ?? date("Y-m-d", strtotime("+" . $result['duration_days'] . " days", strtotime($validation_date)));

        $membership_validity = "
            <p><strong>Plan:</strong> {$result['plan_name']}</p>
            <p><strong>Valid From:</strong> " . date("M d, Y", strtotime($validation_date)) . "</p>
            <p><strong>Expires On:</strong> " . date("M d, Y", strtotime($expiry_date)) . "</p>
            <form method='POST' style='margin-top:10px;'>
                <button type='submit' name='cancel_membership' class='cancel-btn'>Cancel Membership</button>
            </form>
        ";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard</title>
  <link rel="stylesheet" href="./styles/dashboard.css">
  <style>
    .cancel-btn {
      background-color: #b31217;
      color: #fff;
      border: none;
      padding: 8px 15px;
      border-radius: 5px;
      cursor: pointer;
      font-weight: bold;
    }

    .cancel-btn:hover {
      background-color: #8c0f13;
    }
  </style>
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="main-content">
  <div class="container">
    <h1 style="margin-bottom: 5%;border-bottom: 1px solid #333;">DASHBOARD</h1>

    <!-- Profile Header -->
    <div class="profile-header">
      <div class="profile-left">
        <div class="profile-image-wrapper">
          <img src="<?= $profile_image ?>" alt="Athlete Avatar" class="profile-image" style="width:100px;height:100px;border-radius:50%;">
          <a href="profile.php" class="edit-photo-btn" title="Edit Photo">✎</a>
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
        <?= $membership_validity ?>
        <a href="pricing.php" class="btn-view-plans">View Plans</a>
      </div>
    </div>
  </div>
</div>
<script src="./script/test.js"></script>
</body>
</html>
