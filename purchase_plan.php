<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: sign-in.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$plan_id = $_GET['plan_id'] ?? null;

// Step 1: Check if user already has a membership
$stmt = $con->prepare("SELECT membership_id FROM Users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($existing_plan_id);
$stmt->fetch();
$stmt->close();

if ($existing_plan_id !== null) {
    // User already has a membership
    echo "<script>
        alert('You already have an active membership plan. Please contact support to make changes.');
        window.location.href = 'pricing.php';
    </script>";
    exit();
}

// Step 2: Proceed with assigning the membership to the user
if ($plan_id) {
    $stmt = $con->prepare("UPDATE Users SET membership_id = ? WHERE user_id = ?");
    $stmt->bind_param("ii", $plan_id, $user_id);
    if ($stmt->execute()) {
        echo "<script>
            alert('Membership plan purchased successfully!');
            window.location.href = 'dashboard.php';
        </script>";
    } else {
        echo "<script>
            alert('Error purchasing membership plan.');
            window.location.href = 'pricing.php';
        </script>";
    }
    $stmt->close();
} else {
    echo "<script>
        alert('No plan selected.');
        window.location.href = 'pricing.php';
    </script>";
}
?>
