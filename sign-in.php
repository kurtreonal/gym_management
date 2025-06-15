<?php
session_start();
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $stmt = $con->prepare("SELECT user_id, password, first_name FROM Users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 1) {
        $stmt->bind_result($user_id, $hashed_password, $first_name);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $user_id;
            $_SESSION['first_name'] = $first_name;
            header("Location: homepage.php"); // redirect after login
            exit;
        } else {
            echo "<script>alert('Incorrect password.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Email not found.'); window.history.back();</script>";
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
<<<<<<< HEAD
    <a href="homepage.php">
=======
    <a href="test.php">
>>>>>>> d27fa360e6497a947b0e3f18734c7d7c7f921c3f
        <button class="back-button">Back</button>
    </a>
    <h1>Sign In</h1>

    <form action="sign-in.php" method="POST" class="form-single-column">
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
                <a href="sign-up.php">Not Registered?</a>
            </div>
        </div>
    </form>
</body>
</html>
