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
        body { background: #1a1a2e; color: white; font-family: Arial, sans-serif; margin: 0; }
        .header { background: rgba(0,0,0,0.6); padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
        .header a { color: white; text-decoration: none; border: 1px solid #fff; padding: 7px 14px; border-radius: 5px; margin-left: 8px; font-size: 14px; }
        .header a:hover { background: #007bff; }
        h2 { text-align: center; color: white; }
        table { width: 95%; margin: 20px auto; background: rgba(255,255,255,0.92); border-collapse: collapse; border-radius: 8px; font-size: 13px; }
        th, td { padding: 11px 13px; text-align: center; border: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        td { background: #f9f9f9; color: black; }
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
