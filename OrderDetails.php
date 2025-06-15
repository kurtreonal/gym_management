<?php
include 'connection.php';

// Fetch orders with related user and address info (optional join)
$sql = "SELECT o.order_id, u.first_name, u.last_name, a.city, o.admin_id, o.status, o.created_date
        FROM Orders o
        JOIN Users u ON o.user_id = u.user_id
        JOIN User_address a ON o.address_id = a.address_id
        ORDER BY o.created_date DESC";

$result = $con->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Orders Table</title>
    <link rel="stylesheet" href="./styles/adminpage.css">
</head>
<body>
    <?php include 'admin-sidebar.php'; ?>
    <div class="main-content">
        <div class="container">
            <h1>All Orders</h1>
            <table>
                <tr>
                    <th>Order ID</th>
                    <th>User</th>
                    <th>City</th>
                    <th>Admin ID</th>
                    <th>Status</th>
                    <th>Created</th>
                </tr>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>{$row['order_id']}</td>";
                        echo "<td>{$row['first_name']} {$row['last_name']}</td>";
                        echo "<td>{$row['city']}</td>";
                        echo "<td>{$row['admin_id']}</td>";
                        echo "<td><span class='status {$row['status']}'>{$row['status']}</span></td>";
                        echo "<td>{$row['created_date']}</td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='6'>No orders found.</td></tr>";
                }
                $con->close();
                ?>
            </table>
        </div>
    </div>
</body>
</html>
