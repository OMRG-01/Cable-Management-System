<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: 1.customer.php');
    exit;
}
include("connection.php");

$userprofile = $_SESSION['user_name'];

// Fetch customer
$stmt = mysqli_prepare($conn, "SELECT id FROM form1 WHERE hname = ?");
mysqli_stmt_bind_param($stmt, "s", $userprofile);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
$user_id = $row['id'];

// Read POST
$upi_name      = trim($_POST['Upi_name'] ?? '');
$package_name  = trim($_POST['Package_name'] ?? '');
$month         = trim($_POST['month'] ?? '');
$mode_name     = trim($_POST['mode_name'] ?? '');
$transaction_id = trim($_POST['transaction_id'] ?? '');
$price = ($package_name == 'Premium Pack') ? 650 : 450;

// Insert payment record
$ins = mysqli_prepare($conn, "INSERT INTO form8 (user_id, UPI_name, Package_name, month, Mode_name, Price, Transaction_ID, payment_status) VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')");
mysqli_stmt_bind_param($ins, "issssss", $user_id, $upi_name, $package_name, $month, $mode_name, $price, $transaction_id);
mysqli_stmt_execute($ins);
$payment_id = mysqli_insert_id($conn);

// Fetch the just-inserted record for display
$sel = mysqli_prepare($conn, "SELECT * FROM form8 WHERE id = ?");
mysqli_stmt_bind_param($sel, "i", $payment_id);
mysqli_stmt_execute($sel);
$payment_info = mysqli_fetch_assoc(mysqli_stmt_get_result($sel));

$month_names = ['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June',
                '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Receipt</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .receipt { background: white; width: 600px; margin: 0 auto; padding: 30px; border-radius: 10px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #4CAF50; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; }
        th, td { padding: 12px; border: 1px solid #ddd; text-align: left; }
        th { background: #4CAF50; color: white; width: 40%; }
        td { background: #f9f9f9; }
        .status { display: inline-block; background: #ffc107; color: #333; padding: 4px 12px; border-radius: 20px; font-weight: bold; }
        .btn { display: block; margin: 15px auto 0; padding: 10px 30px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 15px; text-decoration: none; text-align: center; width: fit-content; }
        .btn:hover { background: #0056b3; }
        .btn-print { background: #28a745; }
        .note { background: #e8f5e9; border-left: 4px solid #4CAF50; padding: 12px; margin-top: 15px; font-size: 13px; color: #555; }
    </style>
</head>
<body>
    <div class="receipt">
        <h1>Payment Receipt</h1>
        <p style="text-align:center;color:#888;">Reference #<?php echo $payment_info['id']; ?> &mdash; <?php echo date('d M Y'); ?></p>
        <table>
            <tr><th>Customer</th><td><?php echo htmlspecialchars($userprofile); ?></td></tr>
            <tr><th>Package</th><td><?php echo htmlspecialchars($payment_info['Package_name']); ?></td></tr>
            <tr><th>Month</th><td><?php echo $month_names[$payment_info['month']] ?? $payment_info['month']; ?></td></tr>
            <tr><th>Mode</th><td><?php echo htmlspecialchars($payment_info['Mode_name']); ?></td></tr>
            <tr><th>Amount</th><td><strong>Rs. <?php echo $payment_info['Price']; ?>/-</strong></td></tr>
            <tr><th>UPI Paid To</th><td><?php echo htmlspecialchars($payment_info['UPI_name']); ?></td></tr>
            <tr><th>Transaction ID</th><td><?php echo htmlspecialchars($payment_info['Transaction_ID']); ?></td></tr>
            <tr><th>Status</th><td><span class="status"><?php echo $payment_info['payment_status']; ?></span></td></tr>
        </table>
        <div class="note">
            Your payment is under review. Once verified, status will be updated to <strong>Paid</strong>.
            For queries: <strong>9987452112</strong>
        </div>
        <br>
        <a href="CustomerPage.php" class="btn">Back to Dashboard</a>
        <br>
        <button class="btn btn-print" onclick="window.print()">Print Receipt</button>
    </div>
</body>
</html>
