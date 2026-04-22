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
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-image: url('home2.jpg'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; inset: 0; background: linear-gradient(160deg, rgba(15,23,42,0.94) 0%, rgba(15,23,42,0.90) 100%); z-index: 0; }
        .header { position: relative; z-index: 10; background: rgba(15,23,42,0.94); backdrop-filter: blur(14px); padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(59,130,246,0.18); }
        .header span { color: #f1f5f9; font-size: 17px; font-weight: 700; }
        .header a { color: rgba(255,255,255,0.80); text-decoration: none; border: 1px solid rgba(255,255,255,0.14); padding: 7px 16px; border-radius: 8px; margin-left: 8px; font-size: 13px; font-weight: 600; transition: all 0.25s; }
        .header a:hover { background: #3b82f6; border-color: #3b82f6; color: white; }
        .filter-bar { position: relative; z-index: 1; text-align: center; margin: 20px 0 10px; }
        .filter-bar a { color: rgba(255,255,255,0.75); text-decoration: none; border: 1px solid rgba(255,255,255,0.20); padding: 7px 18px; border-radius: 20px; margin: 0 5px; font-size: 13px; font-weight: 500; transition: all 0.25s; }
        .filter-bar a.active, .filter-bar a:hover { background: #3b82f6; border-color: #3b82f6; color: white; }
        h2 { position: relative; z-index: 1; text-align: center; color: #f1f5f9; font-size: 20px; font-weight: 700; margin: 14px 0 18px; }
        table { position: relative; z-index: 1; width: 97%; margin: 0 auto 30px; border-collapse: collapse; background: rgba(30,41,59,0.92); border-radius: 12px; overflow: hidden; box-shadow: 0 4px 22px rgba(0,0,0,0.30); }
        th { background: linear-gradient(135deg,#1e3a5f,#1e40af); color: white; padding: 13px 14px; text-align: left; font-size: 11.5px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        td { padding: 12px 14px; color: #cbd5e1; font-size: 13px; border-bottom: 1px solid rgba(255,255,255,0.05); }
        tr:last-child td { border-bottom: none; }
        tr:hover td { background: rgba(59,130,246,0.07); }
        .badge-pending  { background: rgba(245,158,11,0.18); color: #fcd34d; padding: 4px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; border: 1px solid rgba(245,158,11,0.28); }
        .badge-approved { background: rgba(16,185,129,0.18); color: #6ee7b7; padding: 4px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; border: 1px solid rgba(16,185,129,0.28); }
        .badge-rejected { background: rgba(239,68,68,0.18); color: #fca5a5; padding: 4px 10px; border-radius: 10px; font-size: 11px; font-weight: 700; border: 1px solid rgba(239,68,68,0.28); }
        select { padding: 7px 10px; background: rgba(15,23,42,0.70); border: 1px solid rgba(59,130,246,0.25); border-radius: 7px; color: #f1f5f9; font-size: 12px; font-family: inherit; outline: none; }
        select option { background: #1e293b; }
        .btn-save { background: linear-gradient(135deg,#10b981,#059669); color: white; border: none; padding: 6px 14px; border-radius: 7px; cursor: pointer; font-size: 12px; font-weight: 700; font-family: inherit; transition: all 0.2s; }
        .btn-save:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(16,185,129,0.40); }
        .btn-del  { background: linear-gradient(135deg,#ef4444,#dc2626); color: white; border: none; padding: 6px 12px; border-radius: 7px; cursor: pointer; text-decoration: none; font-size: 12px; font-weight: 700; transition: all 0.2s; }
        .btn-del:hover { transform: translateY(-1px); box-shadow: 0 4px 10px rgba(239,68,68,0.40); }
        p[style*="text-align:center"] { position: relative; z-index: 1; color: #94a3b8; padding: 20px; }
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
