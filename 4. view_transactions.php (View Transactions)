<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: admin_login.php");
    exit();
}

include 'config.php';
$result = $conn->query("SELECT t.id, u.username, t.course_ids, t.total_amount, t.payment_status, t.purchase_timestamp FROM transactions t JOIN users u ON t.user_id = u.id");
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Transactions</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
</head>
<body>
    <div class="d-flex">
        <nav class="bg-dark text-white" style="width: 250px; min-height: 100vh;">
            <!-- Same sidebar as dashboard -->
        </nav>
        <div class="flex-grow-1 p-4">
            <h2>Transactions</h2>
            <table class="table table-striped">
                <thead><tr><th>ID</th><th>User</th><th>Courses</th><th>Total</th><th>Status</th><th>Timestamp</th></tr></thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['username']; ?></td>
                            <td><?php echo implode(', ', json_decode($row['course_ids'], true)); ?></td>
                            <td>$<?php echo $row['total_amount']; ?></td>
                            <td><?php echo $row['payment_status']; ?></td>
                            <td><?php echo $row['purchase_timestamp']; ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>
