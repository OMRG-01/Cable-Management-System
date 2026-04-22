<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

$data  = mysqli_query($conn, "SELECT * FROM form6 ORDER BY id");
$total = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Workers</title>
    <style>
        body { background: #1a1a2e; color: white; font-family: Arial, sans-serif; margin: 0; }
        .header { background: rgba(0,0,0,0.6); padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
        .header a { color: white; text-decoration: none; border: 1px solid #fff; padding: 7px 14px; border-radius: 5px; margin-left: 8px; font-size: 14px; }
        .header a:hover { background: #007bff; }
        .btn-add { background: #28a745; color: white; text-decoration: none; padding: 8px 18px; border-radius: 5px; font-size: 14px; }
        h2 { text-align: center; color: white; }
        table { width: 85%; margin: 20px auto; background: rgba(255,255,255,0.92); border-collapse: collapse; border-radius: 8px; }
        th, td { padding: 12px 15px; text-align: center; border: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        td { background: #f9f9f9; color: black; }
        .btn-edit { background: #007bff; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13px; }
        .btn-del  { background: #dc3545; color: white; border: none; padding: 6px 12px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>
    <div class="header">
        <span>Workers / Technicians</span>
        <div>
            <a href="addworker.php" class="btn-add">+ Add Worker</a>
            <a href="dashboard.php">Dashboard</a>
        </div>
    </div>
    <h2>Workers (<?php echo $total; ?>)</h2>
    <?php if ($total > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Designation</th>
            <th>Salary (Rs.)</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['sname']); ?></td>
            <td><?php echo htmlspecialchars($row['uname']); ?></td>
            <td><?php echo htmlspecialchars($row['dname']); ?></td>
            <td><?php echo number_format($row['hname']); ?></td>
            <td>
                <a href="editworker.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a>
                &nbsp;
                <a href="deleteworker.php?id=<?php echo $row['id']; ?>" class="btn-del"
                   onclick="return confirm('Delete this worker?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center;">No workers found. <a href="addworker.php" style="color:#4CAF50;">Add one now.</a></p>
    <?php endif; ?>
</body>
</html>
