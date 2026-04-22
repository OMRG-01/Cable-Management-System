<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

$query = "SELECT * FROM form1";
$data  = mysqli_query($conn, $query);
$total = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Customers</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-image: url('home2.jpg'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; inset: 0; background: linear-gradient(160deg, rgba(15,23,42,0.94) 0%, rgba(15,23,42,0.90) 100%); z-index: 0; }
        .header { position: relative; z-index: 10; background: rgba(15,23,42,0.94); backdrop-filter: blur(14px); padding: 14px 24px; display: flex; justify-content: flex-end; border-bottom: 1px solid rgba(59,130,246,0.18); }
        .header a { color: rgba(255,255,255,0.80); text-decoration: none; border: 1px solid rgba(255,255,255,0.14); padding: 7px 16px; border-radius: 8px; margin-left: 8px; font-size: 13px; font-weight: 600; transition: all 0.25s; }
        .header a:hover { background: #3b82f6; border-color: #3b82f6; color: white; }
        h2 { position: relative; z-index: 1; text-align: center; color: #f1f5f9; font-size: 20px; font-weight: 700; margin: 22px 0 16px; }
        table { position: relative; z-index: 1; width: 96%; margin: 0 auto 30px; border-collapse: collapse; background: rgba(30,41,59,0.92); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 22px rgba(0,0,0,0.30); }
        th { background: linear-gradient(135deg,#1e3a5f,#1e40af); color: white; padding: 13px 12px; text-align: center; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 11px 12px; text-align: center; color: #cbd5e1; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(59,130,246,0.07); }
        .btn-upd { background: linear-gradient(135deg,#2563eb,#1d4ed8); color: white; border: none; padding: 6px 14px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s; }
        .btn-upd:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(37,99,235,0.40); }
        .btn-del { background: linear-gradient(135deg,#ef4444,#dc2626); color: white; border: none; padding: 6px 14px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s; }
        .btn-del:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(239,68,68,0.40); }
    </style>
</head>
<body>
    <div class="header">
        <a href="dashboard.php">Dashboard</a>
    </div>
    <h2>Manage Customers</h2>
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
            <th>Actions</th>
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
            <td>
                <a href="update_design.php?id=<?php echo $row['id']; ?>" class="btn-upd">Edit</a>
                &nbsp;
                <a href="delete.php?id=<?php echo $row['id']; ?>" class="btn-del"
                   onclick="return confirm('Delete this customer?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <h3 style="text-align:center;color:white;">No customers found.</h3>
    <?php endif; ?>
    <script>function checkdelete(){ return confirm('Are you sure you want to delete this record?'); }</script>
</body>
</html>
