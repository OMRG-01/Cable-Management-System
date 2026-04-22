<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

$admin = htmlspecialchars($_SESSION['admin_name']);

// Dashboard stats
$total_customers   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM form1"));
$total_payments    = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM form8"));
$pending_payments  = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM form8 WHERE payment_status='Pending'"));
$total_workers     = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM form6"));
$open_complaints   = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM complaints WHERE status='Open'"));
$pending_requests  = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM connection_requests WHERE status='Pending'"));
$total_stb         = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM stb_inventory"));
$available_stb     = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM stb_inventory WHERE status='Available'"));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - DIGI NETWORK</title>
    <link rel="stylesheet" href="css/style8.css?v=2">
    <style>
        /* stats-bar override — style8.css handles all other layout */
        .stats-bar {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(140px, 1fr));
            gap: 14px;
            margin-bottom: 26px;
        }
        .stat-card {
            background: rgba(30,41,59,0.88);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(59,130,246,0.18);
            border-radius: 12px;
            padding: 20px 14px;
            text-align: center;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 10px 28px rgba(59,130,246,0.22);
            border-color: rgba(59,130,246,0.40);
        }
        .stat-card h3 { font-size: 2rem; font-weight: 700; color: #3b82f6; margin: 0 0 5px; line-height: 1; }
        .stat-card p  { font-size: 10.5px; color: #94a3b8; margin: 0; font-weight: 600; text-transform: uppercase; letter-spacing: 0.6px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul>
                <li><span style="color:white;padding:8px;">Welcome, <?php echo $admin; ?></span></li>
                <li><a id="currentTime">Time:</a></li>
                <li><a href="adminlogout.php">Logout</a></li>
            </ul>
        </div>
    </div>

    <div class="sidebar">
        <div class="logo">
            <img src="user.png" alt="Admin" width="40">
            <h4>Admin Panel</h4>
        </div>
        <ul class="menu">
            <li><a href="displaycustomer.php">Customer Details</a></li>
            <li><a href="updatecustomer.php">Update Customer</a></li>
            <li><a href="PP.php">Add Plans</a></li>
            <li><a href="Editplans.php">Update Plans</a></li>
            <li><a href="adinvoice.php">Manage Invoices</a></li>
            <li><a href="worker.php">Manage Workers</a></li>
            <li><a href="admincomplaints.php">Complaints</a></li>
            <li><a href="admin_connections.php">Connection Requests</a></li>
            <li><a href="stb.php">STB Inventory</a></li>
        </ul>
    </div>

    <div class="container">
        <!-- Stats -->
        <div class="stats-bar">
            <div class="stat-card">
                <h3><?php echo $total_customers; ?></h3>
                <p>Total Customers</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $total_payments; ?></h3>
                <p>Total Payments</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $pending_payments; ?></h3>
                <p>Pending Payments</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $total_workers; ?></h3>
                <p>Workers</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $open_complaints; ?></h3>
                <p>Open Complaints</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $pending_requests; ?></h3>
                <p>Pending Connections</p>
            </div>
            <div class="stat-card">
                <h3><?php echo $available_stb; ?>/<?php echo $total_stb; ?></h3>
                <p>STB Available</p>
            </div>
        </div>

        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h2>Customers</h2>
                        <h3><a href="updatecustomer.php">Manage</a></h3>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>Plans</h2>
                        <h3><a href="Editplans.php">Manage</a></h3>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>Invoices</h2>
                        <h3><a href="adinvoice.php">Manage</a></h3>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>Workers</h2>
                        <h3><a href="worker.php">Manage</a></h3>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>Complaints</h2>
                        <h3><a href="admincomplaints.php">View</a></h3>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>Connections</h2>
                        <h3><a href="admin_connections.php">Requests</a></h3>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>STB Inventory</h2>
                        <h3><a href="stb.php">Manage</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateCurrentTime() {
            document.getElementById('currentTime').textContent = new Date().toLocaleTimeString();
        }
        updateCurrentTime();
        setInterval(updateCurrentTime, 1000);
    </script>
</body>
</html>
