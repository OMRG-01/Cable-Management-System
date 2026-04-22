<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: 1.customer.php');
    exit;
}
$username = htmlspecialchars($_SESSION['user_name']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Dashboard - DIGI NETWORK</title>
    <link rel="stylesheet" type="text/css" href="css/style7.css">
</head>
<body>
    <div class="header">
        <nav class="navbar">
            <a href="aboutus.php">About Us</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>

    <div class="sidebar">
        <div class="logo">
            <img src="user.png" alt="User" width="40">
            <h4><?php echo $username; ?></h4>
        </div>
        <ul class="menu">
            <li><a href="customerdetails.php">My Details</a></li>
            <li><a href="upcustomer.php">Update Details</a></li>
            <li><a href="editplanC.php">Subscription</a></li>
            <li><a href="pay.php">Payment</a></li>
            <li><a href="viewcomplaints.php">My Complaints</a></li>
        </ul>
    </div>

    <div class="container" style="margin-top:5px;">
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h2>My Details</h2>
                        <h3><a href="customerdetails.php">View</a></h3>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>Subscription</h2>
                        <h3><a href="editplanC.php">View Plans</a></h3>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>Payment</h2>
                        <h3><a href="pay.php">Pay Now</a></h3>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h2>Complaints</h2>
                        <h3><a href="complaints.php">Raise Complaint</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
