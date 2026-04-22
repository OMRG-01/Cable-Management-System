<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $did  = (int)$_GET['delete'];
    $stmt = mysqli_prepare($conn, "DELETE FROM stb_inventory WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $did);
    mysqli_stmt_execute($stmt);
    header('Location: stb.php');
    exit;
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$where  = '';
if ($filter === 'available') $where = " WHERE status='Available'";
if ($filter === 'assigned')  $where = " WHERE status='Assigned'";

$data  = mysqli_query($conn, "SELECT s.*, f1.hname as customer_name FROM stb_inventory s LEFT JOIN form1 f1 ON s.assigned_customer_id=f1.id$where ORDER BY s.id DESC");
$total = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STB Inventory</title>
    <style>
<<<<<<< HEAD
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-image: url('home2.jpg'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; inset: 0; background: linear-gradient(160deg, rgba(15,23,42,0.94) 0%, rgba(15,23,42,0.90) 100%); z-index: 0; }
        .header { position: relative; z-index: 10; background: rgba(15,23,42,0.94); backdrop-filter: blur(14px); padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(59,130,246,0.18); }
        .header span { color: #f1f5f9; font-size: 17px; font-weight: 700; }
        .header a { color: rgba(255,255,255,0.80); text-decoration: none; border: 1px solid rgba(255,255,255,0.14); padding: 7px 16px; border-radius: 8px; margin-left: 8px; font-size: 13px; font-weight: 600; transition: all 0.25s; }
        .header a:hover { background: #3b82f6; border-color: #3b82f6; color: white; }
        .btn-add { background: linear-gradient(135deg,#10b981,#059669) !important; border-color: transparent !important; box-shadow: 0 3px 10px rgba(16,185,129,0.35); }
        .filter-bar { position: relative; z-index: 1; text-align: center; margin: 20px 0 10px; }
        .filter-bar a { color: rgba(255,255,255,0.75); text-decoration: none; border: 1px solid rgba(255,255,255,0.20); padding: 7px 18px; border-radius: 20px; margin: 0 5px; font-size: 13px; font-weight: 500; transition: all 0.25s; }
        .filter-bar a.active, .filter-bar a:hover { background: #3b82f6; border-color: #3b82f6; color: white; }
        h2 { position: relative; z-index: 1; text-align: center; color: #f1f5f9; font-size: 20px; font-weight: 700; margin: 14px 0 18px; }
        table { position: relative; z-index: 1; width: 96%; margin: 0 auto 30px; border-collapse: collapse; background: rgba(30,41,59,0.92); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 22px rgba(0,0,0,0.30); }
        th { background: linear-gradient(135deg,#1e3a5f,#1e40af); color: white; padding: 13px 14px; text-align: center; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 12px 14px; text-align: center; color: #cbd5e1; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(59,130,246,0.07); }
        .badge-avail  { background: rgba(16,185,129,0.18); color: #6ee7b7; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid rgba(16,185,129,0.30); }
        .badge-assign { background: rgba(59,130,246,0.18); color: #93c5fd; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid rgba(59,130,246,0.30); }
        .btn-edit { background: linear-gradient(135deg,#2563eb,#1d4ed8); color: white; border: none; padding: 6px 14px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s; }
        .btn-edit:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(37,99,235,0.4); }
        .btn-del  { background: linear-gradient(135deg,#ef4444,#dc2626); color: white; border: none; padding: 6px 14px; border-radius: 6px; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: 600; transition: all 0.2s; }
        .btn-del:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(239,68,68,0.4); }
        p[style*="text-align:center"] { position: relative; z-index: 1; color: #94a3b8; padding: 20px; }
        p[style*="text-align:center"] a { color: #3b82f6; }
=======
        body { background: #1a1a2e; color: white; font-family: Arial, sans-serif; margin: 0; }
        .header { background: rgba(0,0,0,0.6); padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
        .header a { color: white; text-decoration: none; border: 1px solid #fff; padding: 7px 14px; border-radius: 5px; margin-left: 8px; font-size: 14px; }
        .header a:hover { background: #007bff; }
        .btn-add { background: #28a745; }
        .filter-bar { text-align: center; margin: 15px; }
        .filter-bar a { color: white; text-decoration: none; border: 1px solid #aaa; padding: 6px 16px; border-radius: 20px; margin: 0 5px; font-size: 13px; }
        .filter-bar a.active, .filter-bar a:hover { background: #4CAF50; border-color: #4CAF50; }
        h2 { text-align: center; }
        table { width: 95%; margin: 10px auto; background: rgba(255,255,255,0.93); border-collapse: collapse; font-size: 13px; }
        th, td { padding: 11px 14px; text-align: center; border: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        td { background: #f9f9f9; color: black; }
        .badge-avail  { background: #d4edda; color: #155724; padding: 3px 10px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .badge-assign { background: #cce5ff; color: #004085; padding: 3px 10px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .btn-edit { background: #007bff; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 12px; }
        .btn-del  { background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 12px; }
>>>>>>> f4d76211c5e28b18bc4efdae812dc17bf57f688c
    </style>
</head>
<body>
    <div class="header">
        <span>STB Inventory</span>
        <div>
            <a href="addstb.php" class="btn-add">+ Add STB</a>
            <a href="dashboard.php">Dashboard</a>
        </div>
    </div>
    <div class="filter-bar">
        <?php
        $avail  = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM stb_inventory WHERE status='Available'"));
        $assign = mysqli_num_rows(mysqli_query($conn,"SELECT id FROM stb_inventory WHERE status='Assigned'"));
        ?>
        <a href="?filter=all"       class="<?php echo $filter=='all'?'active':''; ?>">All (<?php echo $avail+$assign; ?>)</a>
        <a href="?filter=available" class="<?php echo $filter=='available'?'active':''; ?>">Available (<?php echo $avail; ?>)</a>
        <a href="?filter=assigned"  class="<?php echo $filter=='assigned'?'active':''; ?>">Assigned (<?php echo $assign; ?>)</a>
    </div>
    <h2>Set-Top Box Inventory (<?php echo $total; ?>)</h2>
    <?php if ($total > 0): ?>
    <table>
        <tr>
            <th>#</th>
            <th>STB Number</th>
            <th>Brand</th>
            <th>Model</th>
            <th>Status</th>
            <th>Assigned To</th>
            <th>Added Date</th>
            <th>Actions</th>
        </tr>
        <?php while ($s = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?php echo $s['id']; ?></td>
            <td><?php echo htmlspecialchars($s['stb_number']); ?></td>
            <td><?php echo htmlspecialchars($s['brand']); ?></td>
            <td><?php echo htmlspecialchars($s['model']); ?></td>
            <td>
                <?php if ($s['status']==='Available'): ?>
                    <span class="badge-avail">Available</span>
                <?php else: ?>
                    <span class="badge-assign">Assigned</span>
                <?php endif; ?>
            </td>
            <td><?php echo $s['customer_name'] ? htmlspecialchars($s['customer_name']) : '—'; ?></td>
            <td><?php echo $s['added_date'] ? date('d M Y', strtotime($s['added_date'])) : '—'; ?></td>
            <td>
                <a href="editstb.php?id=<?php echo $s['id']; ?>" class="btn-edit">Edit</a>
                &nbsp;
                <a href="?delete=<?php echo $s['id']; ?>" class="btn-del"
                   onclick="return confirm('Delete this STB record?')">Delete</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center;">No STB records found. <a href="addstb.php" style="color:#4CAF50;">Add one now.</a></p>
    <?php endif; ?>
</body>
</html>
