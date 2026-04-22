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
        @media print { .no-print { display: none !important; } body { background: white !important; } body::before { display: none !important; } .invoice-container { box-shadow: none; border: 1px solid #ddd; } }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-image: url('home2.jpg'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; padding: 28px 16px; position: relative; }
        body::before { content: ''; position: fixed; inset: 0; background: linear-gradient(160deg, rgba(15,23,42,0.94) 0%, rgba(15,23,42,0.90) 100%); z-index: 0; }
        .no-print { position: relative; z-index: 1; text-align: center; margin-bottom: 18px; display: flex; justify-content: center; gap: 10px; align-items: center; }
        .no-print a { padding: 9px 22px; background: rgba(100,116,139,0.40); color: rgba(255,255,255,0.85); border: 1px solid rgba(255,255,255,0.18); border-radius: 8px; text-decoration: none; font-size: 13px; font-weight: 600; transition: all 0.25s; }
        .no-print a:hover { background: rgba(59,130,246,0.30); border-color: #3b82f6; color: white; }
        .print-btn { display: inline-block; padding: 9px 22px; background: linear-gradient(135deg,#2563eb,#1d4ed8); color: white; border: none; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 700; font-family: inherit; transition: all 0.25s; box-shadow: 0 4px 12px rgba(37,99,235,0.35); }
        .print-btn:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(37,99,235,0.50); }
        .invoice-container { position: relative; z-index: 1; width: 100%; max-width: 720px; margin: 0 auto; background: white; padding: 34px 32px; border-radius: 16px; box-shadow: 0 20px 45px rgba(0,0,0,0.40); }
        .invoice-header { display: flex; justify-content: space-between; align-items: flex-start; border-bottom: 3px solid #3b82f6; padding-bottom: 18px; margin-bottom: 22px; }
        .company-name { font-size: 1.5rem; font-weight: 800; color: #1e3a8a; letter-spacing: 0.5px; }
        .invoice-meta { text-align: right; font-size: 13px; color: #555; line-height: 1.8; }
        h2 { text-align: center; margin-bottom: 22px; color: #1e293b; font-size: 1.1rem; letter-spacing: 2px; text-transform: uppercase; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 22px; border-radius: 8px; overflow: hidden; }
        th { background: linear-gradient(135deg,#1e3a5f,#1e40af); color: white; padding: 12px 16px; text-align: left; font-size: 13px; font-weight: 700; }
        td { padding: 11px 16px; text-align: left; border-bottom: 1px solid #f1f5f9; color: #374151; background: white; font-size: 14px; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f8faff; }
        .paid-stamp { position: absolute; top: 32px; right: 52px; border: 4px solid #10b981; border-radius: 6px; color: #10b981; font-size: 1.6rem; font-weight: 800; padding: 6px 14px; opacity: 0.55; transform: rotate(-15deg); letter-spacing: 2px; }
        p[style*="text-align:center"] { color: #888; font-size: 12px; text-align: center; margin-top: 4px; }
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
