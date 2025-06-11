<?php
include 'connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $date_of_birth = trim($_POST['date_of_birth']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check for duplicate email
    $check = $con->prepare("SELECT email FROM Users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "<script>alert('Email already exists. Please use another.'); window.history.back();</script>";
        exit;
    } else {
        $stmt = $con->prepare("INSERT INTO Users (first_name, last_name,date_of_birth, email, password) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $first_name, $last_name, $date_of_birth, $email, $password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please log in.'); window.location.href = 'sign-in.php';</script>";
            exit;
        } else {
            echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
            exit;
        }
    }

    $check->close();
    $stmt->close();
    $con->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up | The Fighters Club</title>
    <link rel="stylesheet" type="text/css" href="./styles/sign-in-up.css">
</head>
<body>
    <a href="homepage.php">
        <button class="back-button">Back</button>
    </a>
    <br>
    <h1>Sign Up</h1>
    <form action="sign-up.php" method="POST">
        <div class="form_display">
            <div class="form_column left_column">
                <label>First Name</label>
                <input type="text" class="input_deco" name="first_name" placeholder="First Name" required>

                <label>Last Name</label>
                <input type="text" class="input_deco" name="last_name" placeholder="Last Name" required>

                <label>Date of Birth</label>
                <input type="date" class="input_deco" name="date_of_birth" required>
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
