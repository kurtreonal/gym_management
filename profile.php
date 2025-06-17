<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit;
}

$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_image'])) {
    $file = $_FILES['profile_image'];
    $allowed = ['image/jpeg', 'image/png', 'image/gif'];

    if (in_array($file['type'], $allowed) && $file['size'] <= 3 * 1024 * 1024) {
        $imageData = file_get_contents($file['tmp_name']);
        $null = NULL;

        $stmt = $con->prepare("UPDATE users SET profile_image = ? WHERE user_id = ?");
        $stmt->bind_param("bi", $null, $user_id);
        $stmt->send_long_data(0, $imageData);
        $stmt->execute();
    } else {
        $error = "Invalid file. Must be JPEG/PNG/GIF and ≤ 3MB.";
    }
}


// Fetch profile image
$stmt = $con->prepare("SELECT profile_image FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$res = $stmt->get_result();
$user = $res->fetch_assoc();

$profile_image = $user['profile_image']
    ? 'data:image/jpeg;base64,' . base64_encode($user['profile_image'])
    : 'https://profilepicsbucket.crossfit.com/athlete-avatar.jpg';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/dashboard.css">
</head>
<body>
<?php include 'sidebar.php'; ?>
<div class="main-content">
    <div class="container">
        <h1 style="margin-bottom: 5%;border-bottom: 1px solid #333;">Atlete Profile</h1>

        <!-- Top: Add Profile Image UI -->
        <form method="POST" enctype="multipart/form-data">
            <div class="_rowGroup_1ve9l_119 _border_1ve9l_123">
                <div class="_profile-image-container_u8u9n_107">
                    <div class="_profile-image-container_1o7fl_1">
                        <img src="<?= $profile_image ?>" class="_profile-image_1o7fl_1" alt="Profile Image">
                    </div>
                    <div class="_action-container_u8u9n_157">
                        <input type="file" name="profile_image" accept="image/*" required>
                        <button type="submit" class="_button--secondary_1vuwr_79 _button--secondary--light_1vuwr_102 _button--secondary--lg_1vuwr_206">Add Profile Image</button>
                        <p class="_body_rofi5_79 _base_rofi5_87 _mobile-sm_rofi5_97 _normal_rofi5_707">Files must be a JPEG, PNG, or GIF and no larger than 3 MB</p>
                        <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>
                    </div>
                </div>
            </div>
        </form>

        <!-- Bottom: Current Photo Preview -->
        <div class="_current-photo-preview-section">
            <p class="_current-photo-label">Current Photo Preview</p>
            <div class="_current-photo-box">
                <img src="<?= $profile_image ?>" class="_preview-image" alt="Current Profile Image">
            </div>
        </div>
    </div>
</div>
</body>
</html>
