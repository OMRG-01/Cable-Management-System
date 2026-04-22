<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: adinvoice.php');
    exit;
}
$id = (int)$_GET['id'];

// Update status to Paid
$upd = mysqli_prepare($conn, "UPDATE form8 SET payment_status='Paid' WHERE id=?");
mysqli_stmt_bind_param($upd, "i", $id);
mysqli_stmt_execute($upd);

// Fetch record
$sel = mysqli_prepare($conn, "SELECT f8.*, f1.hname, f1.cname, f1.pname FROM form8 f8 LEFT JOIN form1 f1 ON f8.user_id=f1.id WHERE f8.id=?");
mysqli_stmt_bind_param($sel, "i", $id);
mysqli_stmt_execute($sel);
$result = mysqli_fetch_assoc(mysqli_stmt_get_result($sel));

if (!$result) {
    echo "<h2 style='text-align:center'>No record found.</h2>";
    echo "<p style='text-align:center'><a href='adinvoice.php'>Back</a></p>";
    exit;
}

$month_names = ['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June',
                '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?php echo $id; ?></title>
    <style>
        @media print { .no-print { display: none; } body { background: white; } }
        body { font-family: Arial, sans-serif; background: #f4f4f4; margin: 0; padding: 20px; }
        .no-print { text-align: center; margin-bottom: 15px; }
        .no-print a { padding: 8px 20px; background: #6c757d; color: white; border-radius: 5px; text-decoration: none; margin-right: 10px; }
        .invoice-container { width: 700px; margin: auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); position: relative; }
        .invoice-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 2px solid #4CAF50; padding-bottom: 15px; margin-bottom: 20px; }
        .company-name { font-size: 1.5rem; font-weight: bold; color: #2e7d32; }
        .invoice-meta { text-align: right; font-size: 13px; color: #555; }
        h2 { text-align: center; margin-bottom: 20px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { padding: 11px 14px; text-align: left; border: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        td { background: #f9f9f9; }
        .paid-stamp { position: absolute; top: 30px; right: 50px; border: 5px solid #4CAF50; border-radius: 5px; color: #4CAF50; font-size: 1.8rem; font-weight: bold; padding: 8px 15px; opacity: 0.6; transform: rotate(-15deg); }
        .print-btn { display: block; margin: 0 auto; padding: 10px 25px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; font-size: 15px; }
        .print-btn:hover { background: #0056b3; }
    </style>
</head>
<body>
    <div class="no-print">
        <a href="adinvoice.php">&#8592; Back to Invoices</a>
        <button class="print-btn" onclick="window.print()">Print Invoice</button>
    </div>

    <div class="invoice-container">
        <div class="paid-stamp">PAID</div>
        <div class="invoice-header">
            <div>
                <div class="company-name">DIGI NETWORK</div>
                <div style="font-size:13px;color:#777;">Cable TV Service Provider</div>
            </div>
            <div class="invoice-meta">
                <strong>Invoice #<?php echo $id; ?></strong><br>
                Date: <?php echo date('d M Y'); ?><br>
                Status: <span style="color:#28a745;font-weight:bold;">PAID</span>
            </div>
        </div>

        <h2>INVOICE</h2>
        <table>
            <tr><th>Field</th><th>Details</th></tr>
            <tr><td>Customer Username</td><td><?php echo htmlspecialchars($result['hname'] ?? 'N/A'); ?></td></tr>
            <tr><td>Customer Email</td><td><?php echo htmlspecialchars($result['cname'] ?? 'N/A'); ?></td></tr>
            <tr><td>Phone</td><td><?php echo htmlspecialchars($result['pname'] ?? 'N/A'); ?></td></tr>
            <tr><td>Package</td><td><?php echo htmlspecialchars($result['Package_name']); ?></td></tr>
            <tr><td>Month</td><td><?php echo $month_names[$result['month']] ?? $result['month']; ?></td></tr>
            <tr><td>Payment Mode</td><td><?php echo htmlspecialchars($result['Mode_name']); ?></td></tr>
            <tr><td>Amount</td><td><strong>Rs. <?php echo $result['Price']; ?>/-</strong></td></tr>
            <tr><td>UPI Paid To</td><td><?php echo htmlspecialchars($result['UPI_name']); ?></td></tr>
            <tr><td>Transaction ID</td><td><?php echo htmlspecialchars($result['Transaction_ID']); ?></td></tr>
            <tr><td>Payment Status</td><td style="color:#28a745;font-weight:bold;">PAID</td></tr>
        </table>

        <p style="font-size:12px;color:#888;text-align:center;">
            Thank you for your payment. For queries contact: 9987452112 | saylicable99@gmail.com
        </p>
    </div>
</body>
</html>
