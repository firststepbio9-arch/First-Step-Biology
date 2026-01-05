<?php
session_start();
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: admin_login.php");
    exit();
}

include 'config.php';

// Fetch totals
$total_users = $conn->query("SELECT COUNT(*) AS count FROM users WHERE role='user'")->fetch_assoc()['count'];
$total_courses = $conn->query("SELECT COUNT(*) AS count FROM courses")->fetch_assoc()['count'];
$total_orders = $conn->query("SELECT COUNT(*) AS count FROM transactions")->fetch_assoc()['count'];

// Fetch sales data for chart (monthly totals for last 12 months)
$sales_data = [];
for ($i = 11; $i >= 0; $i--) {
    $month = date('Y-m', strtotime("-$i months"));
    $result = $conn->query("SELECT SUM(total_amount) AS total FROM transactions WHERE DATE_FORMAT(purchase_timestamp, '%Y-%m') = '$month'");
    $sales_data[] = $result->fetch_assoc()['total'] ?? 0;
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <nav class="bg-dark text-white" style="width: 250px; min-height: 100vh;">
            <div class="p-3">
                <h5>Admin Panel</h5>
                <ul class="nav flex-column">
                    <li class="nav-item"><a class="nav-link text-white" href="admin_dashboard.php">Dashboard</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="view_transactions.php">View Transactions</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="manage_courses.php">Manage Courses</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="manage_categories.php">Manage Categories</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="manage_payments.php">Manage Payments</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="manage_users.php">Manage Users</a></li>
                    <li class="nav-item"><a class="nav-link text-white" href="logout.php">Logout</a></li>
                </ul>
            </div>
        </nav>

        <!-- Main Content -->
        <div class="flex-grow-1 p-4">
            <h2>Dashboard</h2>
            <div class="row mb-4">
                <div class="col-md-3"><div class="card"><div class="card-body"><h5>Total Users</h5><p><?php echo $total_users; ?></p></div></div></div>
                <div class="col-md-3"><div class="card"><div class="card-body"><h5>Total Courses</h5><p><?php echo $total_courses; ?></p></div></div></div>
                <div class="col-md-3"><div class="card"><div class="card-body"><h5>Total Orders</h5><p><?php echo $total_orders; ?></p></div></div></div>
                <div class="col-md-3"><div class="card"><div class="card-body"><h5>Sales Chart</h5><canvas id="salesChart"></canvas></div></div></div>
            </div>
        </div>
    </div>

    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                datasets: [{
                    label: 'Sales ($)',
                    data: <?php echo json_encode($sales_data); ?>,
                    borderColor: 'rgba(75, 192, 192, 1)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                }]
            }
        });
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.4.0/mdb.min.js"></script>
</body>
</html>
