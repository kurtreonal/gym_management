<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $membership_id = trim($_POST['membership_id']);
    $membership_id = ($membership_id === '' || strtolower($membership_id) === 'null') ? NULL : $membership_id;
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $date_of_birth = $_POST['date_of_birth'];
    $email = trim($_POST['email']);
    $created_date = $_POST['created_date'];

    // Handle password update
    $new_password = trim($_POST['new_password']);
    if (!empty($new_password)) {
        $password = password_hash($new_password, PASSWORD_DEFAULT);
    } else {
        $password = $_POST['password']; // Keep existing hashed password
    }

    $stmt = $con->prepare("UPDATE Users SET membership_id=?, first_name=?, last_name=?, date_of_birth=?, email=?, password=?, created_date=? WHERE user_id=?");
    $stmt->bind_param("issssssi", $membership_id, $first_name, $last_name, $date_of_birth, $email, $password, $created_date, $user_id);


    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully.'); window.location.href = 'adminpage.php';</script>";
    } else {
        echo "<script>alert('Update failed: " . $stmt->error . "'); window.history.back();</script>";
    }

    $stmt->close();
    $con->close();
}
?>
