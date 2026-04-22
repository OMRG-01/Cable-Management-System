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
        @media print { body::before { display: none !important; } body { background: white !important; } .receipt { box-shadow: none !important; border: 1px solid #ddd !important; background: white !important; } .no-print { display: none !important; } th { background: #4CAF50 !important; -webkit-print-color-adjust: exact; } }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-image: url('maincable.png'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; padding: 30px 16px; position: relative; }
        body::before { content: ''; position: fixed; inset: 0; background: linear-gradient(135deg, rgba(26,5,51,0.85) 0%, rgba(45,27,105,0.78) 100%); z-index: 0; }
        .receipt { position: relative; z-index: 1; background: rgba(255,255,255,0.06); backdrop-filter: blur(22px); border: 1px solid rgba(255,255,255,0.13); width: 100%; max-width: 620px; margin: 0 auto; padding: 36px 32px; border-radius: 20px; box-shadow: 0 24px 48px rgba(0,0,0,0.45); }
        h1 { text-align: center; color: white; font-size: 1.6rem; font-weight: 700; margin-bottom: 6px; }
        p[style*="color:#888"] { color: rgba(255,255,255,0.50) !important; text-align: center; margin-bottom: 20px; font-size: 13px; }
        table { width: 100%; border-collapse: collapse; margin: 20px 0; border-radius: 10px; overflow: hidden; }
        th { background: rgba(139,92,246,0.30); color: #c4b5fd; padding: 12px 16px; text-align: left; font-size: 13px; font-weight: 600; border-bottom: 1px solid rgba(139,92,246,0.25); width: 42%; }
        td { padding: 12px 16px; color: #f1f5f9; font-size: 14px; border-bottom: 1px solid rgba(255,255,255,0.07); background: rgba(15,10,40,0.35); }
        tr:last-child th, tr:last-child td { border-bottom: none; }
        .status { display: inline-block; background: rgba(245,158,11,0.20); color: #fcd34d; border: 1px solid rgba(245,158,11,0.35); padding: 4px 14px; border-radius: 20px; font-weight: 700; font-size: 13px; }
        .note { background: rgba(16,185,129,0.12); border-left: 4px solid #10b981; border-radius: 6px; padding: 14px 16px; margin-top: 18px; font-size: 13px; color: #a7f3d0; line-height: 1.7; }
        .note strong { color: #6ee7b7; }
        .btn { display: inline-block; margin: 14px auto 0; padding: 11px 28px; background: linear-gradient(135deg,#7c3aed,#6d28d9); color: white; border: none; border-radius: 10px; cursor: pointer; font-size: 14px; font-weight: 700; font-family: inherit; text-decoration: none; text-align: center; transition: all 0.25s; box-shadow: 0 4px 14px rgba(124,58,237,0.40); }
        .btn:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(124,58,237,0.55); }
        .btn-print { background: linear-gradient(135deg,#10b981,#059669); box-shadow: 0 4px 14px rgba(16,185,129,0.35); margin-left: 10px; }
        .btn-print:hover { box-shadow: 0 8px 20px rgba(16,185,129,0.50); }
        .no-print { position: relative; z-index: 1; text-align: center; margin-bottom: 18px; }
    </style>
</head>
<body>
    <div class="no-print">
        <button class="btn btn-print" onclick="window.print()">Print Receipt</button>
    </div>
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
        <div style="text-align:center;margin-top:20px;">
            <a href="CustomerPage.php" class="btn">Back to Dashboard</a>
        </div>
    </div>
</body>
</html>
