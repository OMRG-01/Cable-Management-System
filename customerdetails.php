<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: 1.customer.php');
    exit;
}
include("connection.php");

$userprofile = $_SESSION['user_name'];
$stmt = mysqli_prepare($conn, "SELECT * FROM form1 WHERE hname = ?");
mysqli_stmt_bind_param($stmt, "s", $userprofile);
mysqli_stmt_execute($stmt);
$result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>My Details</title>
    <link rel="stylesheet" type="text/css" href="style4.css">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul>
                <li><a href="CustomerPage.php">Return</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <div class="title">
            <h1>YOUR DETAILS</h1>
        </div>
        <div class="form">
            <div class="input_field">
                <label>Email ID</label>
                <input type="text" class="input" value="<?php echo htmlspecialchars($result['cname']); ?>" readonly>
            </div>
            <div class="input_field">
                <label>STB-ID</label>
                <input type="text" class="input" value="<?php echo htmlspecialchars($result['sname']); ?>" readonly>
            </div>
            <div class="input_field">
                <label>Phone Number</label>
                <input type="text" class="input" value="<?php echo htmlspecialchars($result['pname']); ?>" readonly>
            </div>
            <div class="input_field">
                <label>Area</label>
                <input type="text" class="input" value="<?php echo htmlspecialchars($result['selname']); ?>" readonly>
            </div>
            <div class="input_field">
                <label>Subscription</label>
                <input type="text" class="input" value="<?php echo htmlspecialchars($result['sename']); ?>" readonly>
            </div>
            <div class="input_field">
                <label>Username</label>
                <input type="text" class="input" value="<?php echo htmlspecialchars($result['hname']); ?>" readonly>
            </div>
            <div class="input_field">
                <a href="upcustomer.php"><button type="button" class="btn">Update Details</button></a>
            </div>
        </div>
    </div>
</body>
</html>
