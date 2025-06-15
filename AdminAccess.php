<?php
include 'connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Prepare and bind
    $stmt = $con->prepare("SELECT admin_id, first_name, last_name, password FROM admin WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();

    $stmt->store_result();
    if ($stmt->num_rows === 1) {
        $stmt->bind_result($admin_id, $first_name, $last_name, $hashed_password);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Password matches, start session
            $_SESSION['admin_id'] = $admin_id;
            $_SESSION['admin_name'] = $first_name . ' ' . $last_name;
            echo "<script>alert('Login successful!'); window.location.href = 'adminpage.php';</script>";
            exit;
        } else {
            echo "<script>alert('Invalid password.'); window.history.back();</script>";
            exit;
        }
    } else {
        echo "<script>alert('No admin found with that email.'); window.history.back();</script>";
        exit;
    }

    $stmt->close();
    $con->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gym Member Login</title>
    <link rel="stylesheet" type="text/css" href="./styles/sign-in-up.css">
</head>
<body>
    <h1>Administrator Sign In</h1>

    <form action="AdminAccess.php" method="POST" class="form-single-column">
        <div class="form_column">
            <label>Email</label>
            <input type="email" class="input_deco" name="email" placeholder="Email" required>

            <label>Password</label>
            <input type="password" class="input_deco" name="password" placeholder="Password" required>
            <a href="#">Forgot Password?</a>

            <div class="form-button-container">
                <button type="submit">Submit</button>
            </div>

            <div style="text-align: center; margin-top: 10px;">
                <a href="sign-u-admin.php">Not Registered?</a>
            </div>
        </div>
    </form>
</body>
</html>
