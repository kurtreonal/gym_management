<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // ── 1. Sanitize & hash ───────────────────────────────────────
    $first_name    = trim($_POST['first_name']);
    $last_name     = trim($_POST['last_name']);
    $email         = trim($_POST['email']);
    $password_hash = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // ── 2. Duplicate-email check ─────────────────────────────────
    $check = $con->prepare("SELECT email FROM admin WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use another.'); window.history.back();</script>";
        exit;
    }

    // ── 3. Insert new admin ──────────────────────────────────────
    $stmt = $con->prepare(
        "INSERT INTO Admin (first_name, last_name, email, password)
         VALUES (?, ?, ?, ?)"
    );
    $stmt->bind_param("ssss", $first_name, $last_name, $email, $password_hash);

    if ($stmt->execute()) {
        echo "<script>alert('Admin registration successful! Please log in.'); window.location.href = 'AdminAccess.php';</script>";
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
    }

    // ── 4. Clean up ──────────────────────────────────────────────
    $check->close();
    $stmt->close();
    $con->close();
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Administrator Sign Up | The Fighters Club</title>
    <link rel="stylesheet" href="./styles/sign-in-up.css" />
</head>
<body>
    <a href="AdminAccess.php"><button class="back-button">Back</button></a>
    <h1>Administrator Sign Up</h1>

    <form action="sign-u-admin.php" method="POST">
        <div class="form_display">
            <div class="form_column left_column">
                <label>First Name</label>
                <input type="text" class="input_deco" name="first_name" placeholder="First Name" required>

                <label>Last Name</label>
                <input type="text" class="input_deco" name="last_name" placeholder="Last Name" required>
            </div>

            <div class="form_column right_column">
                <label>Email</label>
                <input type="email" class="input_deco" name="email" placeholder="Email" required>

                <label>Password</label>
                <input type="password" class="input_deco" name="password" placeholder="Password" required>
            </div>
        </div>

        <div class="form-button-container">
            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>
