<?php
include 'connection.php';

$sql = "SELECT r.report_id, r.order_id, o.status, r.generated_on
        FROM Reports r
        JOIN Orders o ON r.order_id = o.order_id
        ORDER BY r.generated_on DESC";

$result = $con->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Reports Table</title>
    <link rel="stylesheet" href="adminpage.css"> <!-- Your gold-black theme -->
</head>
<body>
    <div class="main_content">
        <h1>Generated Reports</h1>
        <table>
            <tr>
                <th>Report ID</th>
                <th>Order ID</th>
                <th>Status</th>
                <th>Generated On</th>
            </tr>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>{$row['report_id']}</td>";
                    echo "<td>{$row['order_id']}</td>";
                    echo "<td><span class='status {$row['status']}'>{$row['status']}</span></td>";
                    echo "<td>{$row['generated_on']}</td>";
                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='4'>No reports found.</td></tr>";
            }
            $con->close();
            ?>
        </table>
    </div>

    <style>
        /* Reuse status badge styles */
        .status {
            padding: 4px 8px;
            border-radius: 6px;
            text-transform: capitalize;
            font-weight: bold;
        }

        .status.processing {
            background-color: #444;
            color: gold;
        }

        .status.shipped {
            background-color: #1e90ff;
            color: white;
        }

        .status.delivered {
            background-color: #28a745;
            color: white;
        }
    </style>
</body>
</html>
