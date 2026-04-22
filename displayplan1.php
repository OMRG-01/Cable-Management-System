<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: 1.customer.php');
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
        body { background: linear-gradient(135deg,#1a1a2e,#16213e); color: white; font-family: Arial, sans-serif; margin: 0; min-height: 100vh; }
        .header { background: rgba(0,0,0,0.5); padding: 10px 20px; display: flex; justify-content: flex-end; }
        .header a { color: white; text-decoration: none; border: 1px solid #fff; padding: 7px 14px; border-radius: 5px; margin-left: 8px; font-size: 14px; }
        .header a:hover { background: #007bff; }
        h2 { text-align: center; color: #4CAF50; font-size: 1.8rem; }
        .subtitle { text-align: center; color: #aaa; margin-bottom: 20px; }
        table { width: 80%; margin: 10px auto 30px; background: rgba(255,255,255,0.92); border-collapse: collapse; border-radius: 8px; overflow: hidden; }
        th, td { padding: 12px 15px; text-align: center; border: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        td { background: #f9f9f9; color: black; }
    </style>
</head>
<body>
    <div class="header">
        <a href="editplanC.php">&#8592; Back</a>
    </div>
    <h2>Gold Pack — SD Channels</h2>
    <p class="subtitle">Rs. 450/month &bull; <?php echo $total; ?> channels included</p>
    <?php if ($total > 0): ?>
    <table>
        <tr>
            <th>#</th>
            <th>Channel Name</th>
            <th>Code</th>
            <th>Price</th>
            <th>Quality</th>
        </tr>
        <?php while ($row = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['plname']); ?></td>
            <td><?php echo htmlspecialchars($row['pcname']); ?></td>
            <td>Rs. <?php echo $row['prname']; ?></td>
            <td><?php echo htmlspecialchars($row['qname']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center;color:#aaa;">No channels listed yet.</p>
    <?php endif; ?>
</body>
</html>
