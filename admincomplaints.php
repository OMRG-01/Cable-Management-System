<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

// Handle reply + status update
if (isset($_POST['update_complaint'])) {
    $cid    = (int)$_POST['complaint_id'];
    $reply  = trim($_POST['admin_reply']);
    $status = trim($_POST['status']);
    $stmt   = mysqli_prepare($conn, "UPDATE complaints SET admin_reply=?, status=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssi", $reply, $status, $cid);
    mysqli_stmt_execute($stmt);
    header('Location: admincomplaints.php');
    exit;
}

$filter = isset($_GET['filter']) ? $_GET['filter'] : 'all';
$where  = '';
if ($filter === 'open')     $where = " WHERE status='Open'";
if ($filter === 'resolved') $where = " WHERE status='Resolved'";
if ($filter === 'closed')   $where = " WHERE status='Closed'";

$data  = mysqli_query($conn, "SELECT * FROM complaints$where ORDER BY created_at DESC");
$total = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Complaints</title>
    <style>
        body { background: #1a1a2e; color: white; font-family: Arial, sans-serif; margin: 0; }
        .header { background: rgba(0,0,0,0.6); padding: 10px 20px; display: flex; justify-content: space-between; align-items: center; }
        .header a { color: white; text-decoration: none; border: 1px solid #fff; padding: 7px 14px; border-radius: 5px; margin-left: 8px; font-size: 14px; }
        .header a:hover { background: #007bff; }
        .filter-bar { text-align: center; margin: 15px; }
        .filter-bar a { color: white; text-decoration: none; border: 1px solid #aaa; padding: 6px 16px; border-radius: 20px; margin: 0 5px; font-size: 13px; }
        .filter-bar a.active, .filter-bar a:hover { background: #4CAF50; border-color: #4CAF50; }
        h2 { text-align: center; }
        .card { background: white; color: black; border-radius: 8px; padding: 18px; margin: 12px auto; max-width: 800px; box-shadow: 0 2px 8px rgba(0,0,0,0.15); }
        .c-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; }
        .c-subject { font-weight: bold; font-size: 1rem; }
        .c-meta { font-size: 12px; color: #888; margin-bottom: 8px; }
        .c-message { color: #333; margin-bottom: 10px; background: #f9f9f9; padding: 10px; border-radius: 5px; font-size: 14px; }
        .badge-open     { background: #fff3cd; color: #856404; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .badge-resolved { background: #d1ecf1; color: #0c5460; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .badge-closed   { background: #e2e3e5; color: #383d41; padding: 3px 10px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        textarea { width: 100%; padding: 8px; border: 1px solid #ccc; border-radius: 5px; font-size: 13px; resize: vertical; height: 80px; box-sizing: border-box; }
        select { padding: 7px 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 13px; margin-right: 10px; }
        .btn-save { background: #28a745; color: white; border: none; padding: 8px 18px; border-radius: 5px; cursor: pointer; font-size: 13px; }
        .btn-save:hover { background: #1e7e34; }
        .existing-reply { background: #e8f5e9; border-radius: 5px; padding: 10px; font-size: 13px; color: #2e7d32; margin-bottom: 8px; }
    </style>
</head>
<body>
    <div class="header">
        <span>Manage Complaints</span>
        <a href="dashboard.php">Dashboard</a>
    </div>
    <div class="filter-bar">
        <a href="?filter=all"      class="<?php echo $filter=='all'?'active':''; ?>">All (<?php echo mysqli_num_rows(mysqli_query($conn,"SELECT id FROM complaints")); ?>)</a>
        <a href="?filter=open"     class="<?php echo $filter=='open'?'active':''; ?>">Open (<?php echo mysqli_num_rows(mysqli_query($conn,"SELECT id FROM complaints WHERE status='Open'")); ?>)</a>
        <a href="?filter=resolved" class="<?php echo $filter=='resolved'?'active':''; ?>">Resolved</a>
        <a href="?filter=closed"   class="<?php echo $filter=='closed'?'active':''; ?>">Closed</a>
    </div>
    <h2>Complaints (<?php echo $total; ?>)</h2>

    <?php if ($total > 0): ?>
        <?php while ($c = mysqli_fetch_assoc($data)): ?>
        <div class="card">
            <div class="c-header">
                <span class="c-subject">#<?php echo $c['id']; ?> - <?php echo htmlspecialchars($c['subject']); ?></span>
                <?php
                $bc = 'badge-open';
                if ($c['status']==='Resolved') $bc='badge-resolved';
                if ($c['status']==='Closed')   $bc='badge-closed';
                ?>
                <span class="<?php echo $bc; ?>"><?php echo $c['status']; ?></span>
            </div>
            <div class="c-meta">
                From: <strong><?php echo htmlspecialchars($c['username']); ?></strong>
                &mdash; <?php echo date('d M Y, h:i A', strtotime($c['created_at'])); ?>
            </div>
            <div class="c-message"><?php echo nl2br(htmlspecialchars($c['message'])); ?></div>
            <?php if (!empty($c['admin_reply'])): ?>
            <div class="existing-reply"><strong>Previous Reply:</strong> <?php echo nl2br(htmlspecialchars($c['admin_reply'])); ?></div>
            <?php endif; ?>
            <form method="POST">
                <input type="hidden" name="complaint_id" value="<?php echo $c['id']; ?>">
                <textarea name="admin_reply" placeholder="Reply to customer..."><?php echo htmlspecialchars($c['admin_reply'] ?? ''); ?></textarea>
                <div style="margin-top:8px;">
                    <select name="status">
                        <option value="Open"     <?php echo $c['status']=='Open'?'selected':''; ?>>Open</option>
                        <option value="Resolved" <?php echo $c['status']=='Resolved'?'selected':''; ?>>Resolved</option>
                        <option value="Closed"   <?php echo $c['status']=='Closed'?'selected':''; ?>>Closed</option>
                    </select>
                    <button type="submit" name="update_complaint" class="btn-save">Save Response</button>
                </div>
            </form>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;">No complaints found.</p>
    <?php endif; ?>
</body>
</html>
