<?php
<<<<<<< HEAD
    session_start();
    $is_logged_in = isset($_SESSION['admin_id']);
?>

<?php
=======
>>>>>>> d27fa360e6497a947b0e3f18734c7d7c7f921c3f
include 'connection.php';
// Run the query and store result
$sql = "SELECT user_id, membership_id, first_name, last_name, date_of_birth, email, password, created_date FROM Users LIMIT 1";
$result = $con->query($sql);
<<<<<<< HEAD

=======
>>>>>>> d27fa360e6497a947b0e3f18734c7d7c7f921c3f
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Info Table</title>
    <link rel="stylesheet" type="text/css" href="./styles/adminpage.css">
</head>
<body>
    <?php include 'admin-sidebar.php'; ?>
<<<<<<< HEAD
    <div class="main-content">
        <div class="container">
=======
    <div class='main_content'>
>>>>>>> d27fa360e6497a947b0e3f18734c7d7c7f921c3f
        <h1>User Details</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Membership ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Date of Birth</th>
                <th>Email</th>
                <th>Password</th>
                <th>Created Date</th>
                <th>Modify</th>
            </tr>

            <?php
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
<<<<<<< HEAD
                echo "<form action='update_user.php' method='post'>";
                echo "<tr id='userRow'>";
                echo "<td><input type='hidden' name='user_id' value='{$row["user_id"]}'>{$row["user_id"]}</td>";
                echo "<td><input type='text' class='cell-input readonly-field' name='membership_id' value='" . ($row["membership_id"] ?? '') . "' readonly></td>";
                echo "<td><input type='text' class='cell-input' name='first_name' value='{$row["first_name"]}' readonly></td>";
                echo "<td><input type='text' class='cell-input' name='last_name' value='{$row["last_name"]}' readonly></td>";
                echo "<td><input type='date' class='cell-input' name='date_of_birth' value='{$row["date_of_birth"]}' readonly></td>";
                echo "<td><input type='email' class='cell-input' name='email' value='{$row["email"]}' readonly></td>";

                // Password handling: visible mask + hidden real value
                echo "<td>
                    <input type='password' class='cell-input' name='new_password' placeholder='********' readonly>
                    <input type='hidden' name='password' value='{$row["password"]}'>
                </td>";

                echo "<td><input type='text' class='cell-input readonly-field' name='created_date' value='{$row["created_date"]}' readonly></td>";
                echo "<td>
                        <button type='button' class='edit-btn' onclick='enableEdit(this)'>Edit</button>
                        <button type='submit' class='save-btn' onclick='setCurrentDate(this)' style='display:none;'>Save</button>
                    </td>";

                echo "</tr>";
                echo "</form>";
=======
                echo "<tr id='userRow'>";
                echo "<td id='uid'>{$row["user_id"]}</td>";
                echo "<td id='mid'>{$row["membership_id"]}</td>";

                // Editable fields wrapped in input elements
                echo "<td><input class='cell-input' type='text' name='first_name' value='{$row["first_name"]}' readonly></td>";
                echo "<td><input class='cell-input' type='text' name='last_name' value='{$row["last_name"]}' readonly></td>";
                echo "<td><input class='cell-input' type='date' name='date_of_birth' value='{$row["date_of_birth"]}' readonly></td>";
                echo "<td><input class='cell-input' type='email' name='email' value='{$row["email"]}' readonly></td>";
                echo "<td><input class='cell-input' type='text' name='password' value='{$row["password"]}' readonly></td>";
                echo "<td><input class='cell-input' type='text' name='created_date' value='{$row["created_date"]}' readonly></td>";

                // Buttons
                echo "<td>
                        <button class='edit-btn' onclick='enableEdit(this)'>Edit</button>
                        <button class='save-btn' onclick='saveEdit(this)'>Save</button>
                    </td>";
                echo "</tr>";
>>>>>>> d27fa360e6497a947b0e3f18734c7d7c7f921c3f
            } else {
                echo "<tr><td colspan='9'>No user found.</td></tr>";
            }
            $con->close();
            ?>
        </table>
    </div>
<<<<<<< HEAD
    </div>
=======
>>>>>>> d27fa360e6497a947b0e3f18734c7d7c7f921c3f
    <script src="./script/adminscript.js"></script>
</body>
</html>
