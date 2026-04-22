<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

$data  = mysqli_query($conn, "SELECT * FROM form2 WHERE qname='SD Pack' ORDER BY id");
$total = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gold Pack Channels</title>
    <style>
        body { background: #1a1a2e; color: white; font-family: Arial, sans-serif; margin: 0; }
        .header { background: rgba(0,0,0,0.6); padding: 10px 20px; display: flex; justify-content: space-between; }
        .header a { color: white; text-decoration: none; border: 1px solid #fff; padding: 7px 14px; border-radius: 5px; margin-left: 8px; font-size: 14px; }
        .header a:hover { background: #007bff; }
        h2 { text-align: center; color: white; }
        table { width: 80%; margin: 20px auto; background: rgba(255,255,255,0.92); border-collapse: collapse; border-radius: 8px; }
        th, td { padding: 12px; text-align: center; border: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        td { background: #f9f9f9; color: black; }
        .btn-edit { background: #007bff; color: white; border: none; padding: 5px 12px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 13px; }
    </style>
</head>
<body>
    <div class="header">
        <span>Gold Pack (SD) Channels</span>
        <div>
            <a href="plans.php">+ Add Channel</a>
            <a href="Editplans.php">Return</a>
        </div>
    </div>
    <h2>Gold Pack Channels (<?php echo $total; ?>)</h2>
    <?php if ($total > 0): ?>
    <table>
        <tr>
            <th>ID</th>
            <th>Channel Name</th>
            <th>Code</th>
            <th>Price (Rs.)</th>
            <th>Quality</th>
            <th>Actions</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['plname']); ?></td>
            <td><?php echo htmlspecialchars($row['pcname']); ?></td>
            <td><?php echo $row['prname']; ?></td>
            <td><?php echo htmlspecialchars($row['qname']); ?></td>
            <td><a href="update_plan.php?id=<?php echo $row['id']; ?>" class="btn-edit">Edit</a></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center;">No channels found.</p>
    <?php endif; ?>
</body>
</html>
