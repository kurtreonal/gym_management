<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: sign-in.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$plan_id = intval($_GET['plan_id']);

// Get user info
$stmt = $con->prepare("SELECT first_name, last_name FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result()->fetch_assoc();

$first_initial = strtoupper(substr($user_result['first_name'], 0, 1));
$last_initial = strtoupper(substr($user_result['last_name'], 0, 1));
$date = new DateTime();
$day = $date->format('d');
$month = $date->format('m');
$today = $date->format('Y-m-d');
$expiry = $date->modify('+1 month')->format('Y-m-d');

// Generate FCID
$random = str_pad(mt_rand(0, 9999), 4, '0', STR_PAD_LEFT);
$fcid = "{$first_initial}{$last_initial}{$day}{$month}{$plan_id}{$random}";

// Update user record with membership info
$update = $con->prepare("UPDATE users SET membership_id=?, fcid=?, validation_date=?, expiry_date=? WHERE user_id=?");
$update->bind_param("isssi", $plan_id, $fcid, $today, $expiry, $user_id);
$update->execute();

header("Location: account_settings.php");
exit;

?>
