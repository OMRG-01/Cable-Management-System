<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

// Handle status update
if (isset($_POST['update_status'])) {
    $rid    = (int)$_POST['request_id'];
    $status = trim($_POST['status']);
    $stmt   = mysqli_prepare($conn, "UPDATE connection_requests SET status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "si", $status, $rid);
    mysqli_stmt_execute($stmt);
    header('Location: admin_connections.php');
    exit;
}

// Handle delete
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $did  = (int)$_GET['delete'];
    $stmt = mysqli_prepare($conn, "DELETE FROM connection_requests WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $did);
    mysqli_stmt_execute($stmt);
    header('Location: admin_connections.php');
    exit;
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$where  = '';
if ($filter === 'pending')  $where = " WHERE status='Pending'";
if ($filter === 'approved') $where = " WHERE status='Approved'";
if ($filter === 'rejected') $where = " WHERE status='Rejected'";

$data  = mysqli_query($conn, "SELECT * FROM connection_requests$where ORDER BY created_at DESC");
$total = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connection Requests</title>
    <style>
        body { background: #1a1a2e; color: white; font-family: Arial, sans-serif; margin: 0; }
        .header { background: rgba(0,0,0,0.6); padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
        .header a { color: white; text-decoration: none; border: 1px solid #fff; padding: 7px 14px; border-radius: 5px; margin-left: 8px; font-size: 14px; }
        .header a:hover { background: #007bff; }
        .filter-bar { text-align: center; margin: 15px; }
        .filter-bar a { color: white; text-decoration: none; border: 1px solid #aaa; padding: 6px 16px; border-radius: 20px; margin: 0 5px; font-size: 13px; }
        .filter-bar a.active, .filter-bar a:hover { background: #4CAF50; border-color: #4CAF50; }
        h2 { text-align: center; }
        table { width: 97%; margin: 10px auto; background: rgba(255,255,255,0.93); border-collapse: collapse; font-size: 13px; }
        th, td { padding: 10px 12px; text-align: left; border: 1px solid #ddd; }
        th { background: #4CAF50; color: white; }
        td { background: #f9f9f9; color: black; }
        .badge-pending  { background: #fff3cd; color: #856404; padding: 3px 9px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .badge-approved { background: #d4edda; color: #155724; padding: 3px 9px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        .badge-rejected { background: #f8d7da; color: #721c24; padding: 3px 9px; border-radius: 10px; font-size: 11px; font-weight: bold; }
        select { padding: 5px 8px; border: 1px solid #ccc; border-radius: 4px; font-size: 12px; }
        .btn-save { background: #28a745; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; font-size: 12px; }
        .btn-del  { background: #dc3545; color: white; border: none; padding: 5px 10px; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 12px; }
    </style>
</head>
<body>
    <div class="header">
        <span>Connection Requests</span>
        <a href="dashboard.php">Dashboard</a>
    </div>
    <div class="filter-bar">
        <?php
        $counts = [];
        foreach (['Pending','Approved','Rejected'] as $s) {
            $counts[$s] = mysqli_num_rows(mysqli_query($conn, "SELECT id FROM connection_requests WHERE status='$s'"));
        }
        ?>
        <a href="?filter=all"      class="<?php echo $filter=='all'?'active':''; ?>">All (<?php echo array_sum($counts); ?>)</a>
        <a href="?filter=pending"  class="<?php echo $filter=='pending'?'active':''; ?>">Pending (<?php echo $counts['Pending']; ?>)</a>
        <a href="?filter=approved" class="<?php echo $filter=='approved'?'active':''; ?>">Approved (<?php echo $counts['Approved']; ?>)</a>
        <a href="?filter=rejected" class="<?php echo $filter=='rejected'?'active':''; ?>">Rejected (<?php echo $counts['Rejected']; ?>)</a>
    </div>
    <h2>Connection Requests (<?php echo $total; ?>)</h2>
    <?php if ($total > 0): ?>
    <table>
        <tr>
            <th>#</th>
            <th>Name</th>
            <th>Phone</th>
            <th>Email</th>
            <th>Area</th>
            <th>Plan</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
        <?php while ($r = mysqli_fetch_assoc($data)): ?>
        <tr>
            <td><?php echo $r['id']; ?></td>
            <td><?php echo htmlspecialchars($r['full_name']); ?></td>
            <td><?php echo htmlspecialchars($r['phone']); ?></td>
            <td><?php echo htmlspecialchars($r['email']); ?></td>
            <td><?php echo htmlspecialchars($r['area']); ?></td>
            <td><?php echo htmlspecialchars($r['subscription_type']); ?></td>
            <td><?php echo date('d M Y', strtotime($r['created_at'])); ?></td>
            <td>
                <?php
                $bc = 'badge-pending';
                if ($r['status']==='Approved') $bc='badge-approved';
                if ($r['status']==='Rejected') $bc='badge-rejected';
                ?>
                <span class="<?php echo $bc; ?>"><?php echo $r['status']; ?></span>
            </td>
            <td>
                <form method="POST" style="display:inline;">
                    <input type="hidden" name="request_id" value="<?php echo $r['id']; ?>">
                    <select name="status">
                        <option value="Pending"  <?php echo $r['status']==='Pending'?'selected':''; ?>>Pending</option>
                        <option value="Approved" <?php echo $r['status']==='Approved'?'selected':''; ?>>Approved</option>
                        <option value="Rejected" <?php echo $r['status']==='Rejected'?'selected':''; ?>>Rejected</option>
                    </select>
                    <button type="submit" name="update_status" class="btn-save">Save</button>
                </form>
                &nbsp;
                <a href="?delete=<?php echo $r['id']; ?>" class="btn-del"
                   onclick="return confirm('Delete this request?')">Del</a>
            </td>
        </tr>
        <?php endwhile; ?>
    </table>
    <?php else: ?>
        <p style="text-align:center;">No requests found.</p>
    <?php endif; ?>
</body>
</html>
