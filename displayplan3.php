<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: 1.customer.php');
    exit;
}
include("connection.php");

$data  = mysqli_query($conn, "SELECT * FROM form5 WHERE uname='HD Pack' ORDER BY id");
$total = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Premium Pack Channels</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-image: url('maincable.png'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; inset: 0; background: linear-gradient(135deg, rgba(26,5,51,0.82) 0%, rgba(45,27,105,0.75) 100%); z-index: 0; }
        .header { position: relative; z-index: 10; background: rgba(15,10,40,0.92); backdrop-filter: blur(14px); padding: 14px 24px; display: flex; justify-content: flex-end; border-bottom: 1px solid rgba(139,92,246,0.25); }
        .header a { color: rgba(255,255,255,0.80); text-decoration: none; border: 1px solid rgba(139,92,246,0.40); padding: 7px 16px; border-radius: 8px; margin-left: 8px; font-size: 13px; font-weight: 600; transition: all 0.25s; }
        .header a:hover { background: #8b5cf6; border-color: #8b5cf6; color: white; }
        h2 { position: relative; z-index: 1; text-align: center; color: white; font-size: 1.7rem; font-weight: 700; margin: 26px 0 6px; text-shadow: 0 2px 8px rgba(0,0,0,0.3); }
        .subtitle { position: relative; z-index: 1; text-align: center; color: rgba(255,255,255,0.55); margin-bottom: 20px; font-size: 14px; }
        table { position: relative; z-index: 1; width: 82%; margin: 0 auto 30px; border-collapse: collapse; background: rgba(255,255,255,0.95); border-radius: 14px; overflow: hidden; box-shadow: 0 6px 28px rgba(0,0,0,0.25); }
        th { background: linear-gradient(135deg,#1e1b4b,#2d1b69); color: white; padding: 13px 15px; text-align: center; font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 12px 15px; text-align: center; color: #374151; font-size: 13px; border-bottom: 1px solid #f3f4f6; }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: #f5f3ff; }
    </style>
</head>
<body>
    <div class="header">
        <a href="editplanC.php">&#8592; Back</a>
    </div>
    <h2>Premium Pack — HD Channels</h2>
    <p class="subtitle">Rs. 650/month &bull; <?php echo $total; ?> HD channels included</p>
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
            <td><?php echo htmlspecialchars($row['mname']); ?></td>
            <td><?php echo htmlspecialchars($row['aname']); ?></td>
            <td>Rs. <?php echo $row['yname']; ?></td>
            <td><?php echo htmlspecialchars($row['uname']); ?></td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center;color:#aaa;">No channels listed yet.</p>
    <?php endif; ?>
</body>
</html>
