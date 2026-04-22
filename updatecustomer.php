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
        body { background: #1a1a2e; color: white; font-family: Arial, sans-serif; margin: 0; }
        .header { background: rgba(0,0,0,0.6); padding: 10px 20px; display: flex; justify-content: flex-end; }
        .header a { color: white; text-decoration: none; border: 1px solid #fff; padding: 8px 15px; margin-left: 10px; border-radius: 5px; }
        .header a:hover { background: #007bff; }
        table { width: 95%; margin: 20px auto; background: rgba(255,255,255,0.9); border-collapse: collapse; border-radius: 8px; }
        th, td { padding: 12px; text-align: center; border: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        td { background: #f9f9f9; color: black; }
        h2 { text-align: center; color: white; }
        .btn-upd { background: #007bff; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13px; }
        .btn-del { background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13px; }
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
