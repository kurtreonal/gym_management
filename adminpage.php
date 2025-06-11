<?php
include 'connection.php';
// Run the query and store result
$sql = "SELECT user_id, membership_id, first_name, last_name, date_of_birth, email, password, created_date FROM Users LIMIT 1";
$result = $con->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>User Info Table</title>
    <link rel="stylesheet" type="text/css" href="./styles/adminpage.css">
</head>
<body>
    <?php include 'admin-sidebar.php'; ?>
    <div class='main_content'>
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
            } else {
                echo "<tr><td colspan='9'>No user found.</td></tr>";
            }
            $con->close();
            ?>
        </table>
    </div>
    <script src="./script/adminscript.js"></script>
</body>
</html>
