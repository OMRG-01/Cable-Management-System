<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Plans</title>
    <link rel="stylesheet" href="css/style8.css?v=2">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul>
                <li><a href="adminlogout.php">Logout</a></li>
                <li><a href="dashboard.php">Dashboard</a></li>
            </ul>
        </div>
    </div>
    <div class="sidebar">
        <div class="logo">
            <h4>Admin Panel</h4>
        </div>
        <ul class="menu">
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="PP.php">Add Plans</a></li>
        </ul>
    </div>
    <div class="container">
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h2>Gold Pack Channels (SD)</h2>
                        <h3><a href="displayplan.php">View / Edit</a></h3>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>Premium Pack Channels (HD)</h2>
                        <h3><a href="displayplan2.php">View / Edit</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
