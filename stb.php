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
