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
<<<<<<< HEAD
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-image: url('home2.jpg'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; inset: 0; background: linear-gradient(160deg, rgba(15,23,42,0.94) 0%, rgba(15,23,42,0.90) 100%); z-index: 0; }
        .header { position: relative; z-index: 10; background: rgba(15,23,42,0.94); backdrop-filter: blur(14px); padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(59,130,246,0.18); }
        .header span { color: #f1f5f9; font-size: 17px; font-weight: 700; letter-spacing: 0.3px; }
        .header a { color: rgba(255,255,255,0.80); text-decoration: none; border: 1px solid rgba(255,255,255,0.14); padding: 7px 16px; border-radius: 8px; margin-left: 8px; font-size: 13px; font-weight: 600; transition: all 0.25s; }
        .header a:hover { background: #3b82f6; border-color: #3b82f6; color: white; }
        .filter-bar { position: relative; z-index: 1; text-align: center; margin: 20px 0 10px; }
        .filter-bar a { color: rgba(255,255,255,0.75); text-decoration: none; border: 1px solid rgba(255,255,255,0.20); padding: 7px 18px; border-radius: 20px; margin: 0 5px; font-size: 13px; font-weight: 500; transition: all 0.25s; }
        .filter-bar a.active, .filter-bar a:hover { background: #3b82f6; border-color: #3b82f6; color: white; }
        h2 { position: relative; z-index: 1; text-align: center; color: #f1f5f9; font-size: 20px; font-weight: 700; margin: 14px 0 18px; }
        .card { position: relative; z-index: 1; background: rgba(30,41,59,0.92); backdrop-filter: blur(12px); border: 1px solid rgba(59,130,246,0.18); border-radius: 14px; padding: 20px; margin: 12px auto; max-width: 820px; }
        .c-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 10px; }
        .c-subject { font-weight: 700; font-size: 15px; color: #f1f5f9; }
        .c-meta { font-size: 12px; color: #94a3b8; margin-bottom: 10px; }
        .c-message { color: #cbd5e1; margin-bottom: 12px; background: rgba(15,23,42,0.50); padding: 12px 14px; border-radius: 8px; font-size: 13px; line-height: 1.6; }
        .badge-open     { background: rgba(245,158,11,0.18); color: #fcd34d; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid rgba(245,158,11,0.30); }
        .badge-resolved { background: rgba(59,130,246,0.18); color: #93c5fd; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid rgba(59,130,246,0.30); }
        .badge-closed   { background: rgba(148,163,184,0.18); color: #94a3b8; padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 700; border: 1px solid rgba(148,163,184,0.25); }
        textarea { width: 100%; padding: 10px 12px; background: rgba(15,23,42,0.60); border: 1px solid rgba(59,130,246,0.22); border-radius: 8px; color: #f1f5f9; font-size: 13px; font-family: inherit; resize: vertical; height: 80px; box-sizing: border-box; outline: none; }
        textarea:focus { border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,0.20); }
        select { padding: 8px 12px; background: rgba(15,23,42,0.60); border: 1px solid rgba(59,130,246,0.22); border-radius: 8px; color: #f1f5f9; font-size: 13px; font-family: inherit; margin-right: 10px; outline: none; }
        select option { background: #1e293b; }
        .btn-save { background: linear-gradient(135deg, #10b981, #059669); color: white; border: none; padding: 8px 20px; border-radius: 8px; cursor: pointer; font-size: 13px; font-weight: 700; font-family: inherit; transition: all 0.25s; box-shadow: 0 4px 12px rgba(16,185,129,0.30); }
        .btn-save:hover { transform: translateY(-1px); box-shadow: 0 6px 18px rgba(16,185,129,0.45); }
        .existing-reply { background: rgba(16,185,129,0.12); border: 1px solid rgba(16,185,129,0.25); border-radius: 8px; padding: 10px 14px; font-size: 13px; color: #6ee7b7; margin-bottom: 10px; }
        p[style*="text-align:center"] { position: relative; z-index: 1; color: #94a3b8; }
=======
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
>>>>>>> f4d76211c5e28b18bc4efdae812dc17bf57f688c
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
