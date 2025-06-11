<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="./styles/dashboard.css">
</head>
<body>
    <?php
    include 'sidebar.php';
    ?>
<div class="main-content">
    <div class="container">
<h1 style="margin-bottom: 5%;border-bottom: 1px solid #333;">Atlete Profile</h1>
  <!-- Top: Add Profile Image UI -->
  <div class="_rowGroup_1ve9l_119 _border_1ve9l_123">
    <div class="_profile-image-container_u8u9n_107">
      <div class="_profile-image-container_1o7fl_1">
        <img src="https://profilepicsbucket.crossfit.com/athlete-avatar.jpg" class="_profile-image_1o7fl_1" alt="Profile Image">
      </div>
      <div class="_action-container_u8u9n_157">
        <button type="button" class="_button--secondary_1vuwr_79 _button--secondary--light_1vuwr_102 _button--secondary--lg_1vuwr_206">Add Profile Image</button>
        <p class="_body_rofi5_79 _base_rofi5_87 _mobile-sm_rofi5_97 _normal_rofi5_707">Files must be a JPEG, PNG, or GIF and no larger than 3 MB</p>
      </div>
    </div>
  </div>

  <!-- Bottom: Current Photo Preview -->
  <div class="_current-photo-preview-section">
    <p class="_current-photo-label">Current Photo Preview</p>
    <div class="_current-photo-box">
      <img src="https://profilepicsbucket.crossfit.com/athlete-avatar.jpg" class="_preview-image" alt="Current Profile Image">
    </div>
  </div>
</div>
</div>

</body>
</html>