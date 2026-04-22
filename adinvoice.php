<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

// Handle mark as paid inline
if (isset($_GET['markpaid']) && is_numeric($_GET['markpaid'])) {
    $pid = (int)$_GET['markpaid'];
    $upd = mysqli_prepare($conn, "UPDATE form8 SET payment_status='Paid' WHERE id=?");
    mysqli_stmt_bind_param($upd, "i", $pid);
    mysqli_stmt_execute($upd);
    header('Location: adinvoice.php');
    exit;
}

// Filter
$filter  = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$where   = '';
if ($filter === 'pending') $where = " WHERE payment_status='Pending'";
if ($filter === 'paid')    $where = " WHERE payment_status='Paid'";

$data  = mysqli_query($conn, "SELECT * FROM form8$where ORDER BY id DESC");
$total = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Invoices</title>
    <style>
<<<<<<< HEAD
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-image: url('home2.jpg'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; inset: 0; background: linear-gradient(160deg, rgba(15,23,42,0.94) 0%, rgba(15,23,42,0.90) 100%); z-index: 0; }
        .header { position: relative; z-index: 10; background: rgba(15,23,42,0.94); backdrop-filter: blur(14px); padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(59,130,246,0.18); }
        .header span { color: #f1f5f9; font-size: 17px; font-weight: 700; }
        .header a { color: rgba(255,255,255,0.80); text-decoration: none; border: 1px solid rgba(255,255,255,0.14); padding: 7px 16px; border-radius: 8px; margin-left: 8px; font-size: 13px; font-weight: 600; transition: all 0.25s; }
        .header a:hover { background: #3b82f6; border-color: #3b82f6; color: white; }
        .filter-bar { position: relative; z-index: 1; text-align: center; margin: 20px 0 10px; }
        .filter-bar a { color: rgba(255,255,255,0.75); text-decoration: none; border: 1px solid rgba(255,255,255,0.20); padding: 7px 18px; border-radius: 20px; margin: 0 5px; font-size: 13px; font-weight: 500; transition: all 0.25s; }
        .filter-bar a.active, .filter-bar a:hover { background: #3b82f6; border-color: #3b82f6; color: white; }
        h2 { position: relative; z-index: 1; text-align: center; color: #f1f5f9; font-size: 20px; font-weight: 700; margin: 14px 0 18px; }
        table { position: relative; z-index: 1; width: 98%; margin: 0 auto 30px; border-collapse: collapse; background: rgba(30,41,59,0.92); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 22px rgba(0,0,0,0.30); }
        th { background: linear-gradient(135deg,#1e3a5f,#1e40af); color: white; padding: 13px 12px; text-align: center; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 11px 12px; text-align: center; color: #cbd5e1; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(59,130,246,0.07); }
        .btn-green { background: linear-gradient(135deg,#10b981,#059669); color: white; border: none; padding: 5px 12px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s; }
        .btn-green:hover { transform: translateY(-1px); box-shadow: 0 3px 8px rgba(16,185,129,0.40); }
        .btn-blue  { background: linear-gradient(135deg,#2563eb,#1d4ed8); color: white; border: none; padding: 5px 12px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s; }
        .btn-blue:hover { transform: translateY(-1px); box-shadow: 0 3px 8px rgba(37,99,235,0.40); }
        .badge-pending { background: rgba(245,158,11,0.18); color: #fcd34d; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid rgba(245,158,11,0.30); }
        .badge-paid    { background: rgba(16,185,129,0.18); color: #6ee7b7; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid rgba(16,185,129,0.30); }
        p[style*="text-align:center"] { position: relative; z-index: 1; color: #94a3b8; padding: 20px; }
=======
        body { background: #1a1a2e; color: white; font-family: Arial, sans-serif; margin: 0; }
        .header { background: rgba(0,0,0,0.6); padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
        .header a { color: white; text-decoration: none; border: 1px solid #fff; padding: 7px 14px; border-radius: 5px; margin-left: 8px; font-size: 14px; }
        .header a:hover { background: #007bff; }
        .filter-bar { text-align: center; margin: 15px; }
        .filter-bar a { color: white; text-decoration: none; border: 1px solid #aaa; padding: 6px 16px; border-radius: 20px; margin: 0 5px; font-size: 13px; }
        .filter-bar a.active, .filter-bar a:hover { background: #4CAF50; border-color: #4CAF50; }
        h2 { text-align: center; color: white; }
        table { width: 98%; margin: 10px auto; background: rgba(255,255,255,0.92); border-collapse: collapse; font-size: 13px; }
        th, td { padding: 10px; text-align: center; border: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        td { background: #f9f9f9; color: black; }
        .btn-green  { background: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 12px; }
        .btn-blue   { background: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 12px; }
        .badge-pending { background: #ffc107; color: #333; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .badge-paid    { background: #28a745; color: white; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; }
>>>>>>> f4d76211c5e28b18bc4efdae812dc17bf57f688c
    </style>
</head>
<body>
    <div class="header">
        <span>Manage Invoices</span>
        <a href="dashboard.php">Dashboard</a>
    </div>
    <div class="filter-bar">
        <a href="?filter=all"     class="<?php echo $filter=='all'?'active':''; ?>">All</a>
        <a href="?filter=pending" class="<?php echo $filter=='pending'?'active':''; ?>">Pending</a>
        <a href="?filter=paid"    class="<?php echo $filter=='paid'?'active':''; ?>">Paid</a>
    </div>
    <h2>Payment Records (<?php echo $total; ?>)</h2>
    <?php if ($total > 0): ?>
    <table>
        <tr>
            <th>#</th>
            <th>User ID</th>
            <th>Package</th>
            <th>Month</th>
            <th>Mode</th>
            <th>Amount</th>
            <th>Transaction ID</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['user_id']; ?></td>
            <td><?php echo htmlspecialchars($row['Package_name']); ?></td>
            <td><?php echo $row['month']; ?></td>
            <td><?php echo htmlspecialchars($row['Mode_name']); ?></td>
            <td>Rs. <?php echo $row['Price']; ?></td>
            <td><?php echo htmlspecialchars($row['Transaction_ID']); ?></td>
            <td>
                <?php if ($row['payment_status'] === 'Paid'): ?>
                    <span class="badge-paid">Paid</span>
                <?php else: ?>
                    <span class="badge-pending">Pending</span>
                <?php endif; ?>
            </td>
            <td>
                <a href="finalinvoice.php?id=<?php echo $row['id']; ?>" class="btn-blue">Invoice</a>
                <?php if ($row['payment_status'] !== 'Paid'): ?>
                    &nbsp;<a href="?markpaid=<?php echo $row['id']; ?>" class="btn-green"
                       onclick="return confirm('Mark this payment as Paid?')">Mark Paid</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center;">No records found.</p>
    <?php endif; ?>
</body>
</html>
