<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

$data  = mysqli_query($conn, "SELECT * FROM form1 ORDER BY id");
$total = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-image: url('home2.jpg'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; inset: 0; background: linear-gradient(160deg, rgba(15,23,42,0.94) 0%, rgba(15,23,42,0.90) 100%); z-index: 0; }
        .header { position: relative; z-index: 10; background: rgba(15,23,42,0.94); backdrop-filter: blur(14px); padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(59,130,246,0.18); }
        .header span { color: #f1f5f9; font-size: 17px; font-weight: 700; }
        .header a { color: rgba(255,255,255,0.80); text-decoration: none; border: 1px solid rgba(255,255,255,0.14); padding: 7px 16px; border-radius: 8px; margin-left: 8px; font-size: 13px; font-weight: 600; transition: all 0.25s; }
        .header a:hover { background: #3b82f6; border-color: #3b82f6; color: white; }
        h2 { position: relative; z-index: 1; text-align: center; color: #f1f5f9; font-size: 20px; font-weight: 700; margin: 22px 0 16px; }
        table { position: relative; z-index: 1; width: 96%; margin: 0 auto 30px; border-collapse: collapse; background: rgba(30,41,59,0.92); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 22px rgba(0,0,0,0.30); }
        th { background: linear-gradient(135deg,#1e3a5f,#1e40af); color: white; padding: 13px 14px; text-align: center; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 12px 14px; text-align: center; color: #cbd5e1; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(59,130,246,0.07); }
    </style>
</head>
<body>
    <div class="header">
        <span>Customer Details</span>
        <div>
            <a href="updatecustomer.php">Manage / Edit</a>
            <a href="dashboard.php">Dashboard</a>
        </div>
    </div>
    <h2>All Customers (<?php echo $total; ?>)</h2>
    <?php if ($total > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Email</th>
            <th>STB-ID</th>
            <th>Phone</th>
            <th>Area</th>
            <th>Subscription</th>
            <th>Username</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['cname']); ?></td>
            <td><?php echo htmlspecialchars($row['sname']); ?></td>
            <td><?php echo htmlspecialchars($row['pname']); ?></td>
            <td><?php echo htmlspecialchars($row['selname']); ?></td>
            <td><?php echo htmlspecialchars($row['sename']); ?></td>
            <td><?php echo htmlspecialchars($row['hname']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center;">No customers found.</p>
    <?php endif; ?>
</body>
</html>
