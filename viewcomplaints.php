<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: 1.customer.php');
    exit;
}
include("connection.php");

$userprofile = $_SESSION['user_name'];
$s = mysqli_prepare($conn, "SELECT id FROM form1 WHERE hname=?");
mysqli_stmt_bind_param($s, "s", $userprofile);
mysqli_stmt_execute($s);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
$user_id = $row['id'];

$data  = mysqli_query($conn, "SELECT * FROM complaints WHERE user_id=$user_id ORDER BY created_at DESC");
$total = mysqli_num_rows($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Complaints</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-image: url('maincable.png'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; inset: 0; background: linear-gradient(135deg, rgba(26,5,51,0.82) 0%, rgba(45,27,105,0.75) 100%); z-index: 0; }
        .header { position: relative; z-index: 10; background: rgba(15,10,40,0.92); backdrop-filter: blur(14px); padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(139,92,246,0.25); }
        .header h2 { margin: 0; font-size: 16px; font-weight: 700; color: white; }
        .header a { color: rgba(255,255,255,0.80); text-decoration: none; border: 1px solid rgba(139,92,246,0.40); padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-left: 8px; transition: all 0.25s; }
        .header a:hover { background: #8b5cf6; border-color: #8b5cf6; color: white; }
        h2 { position: relative; z-index: 1; text-align: center; color: white; font-size: 20px; font-weight: 700; margin: 22px 0 16px; }
        .complaint-card { position: relative; z-index: 1; background: rgba(30,20,60,0.88); backdrop-filter: blur(12px); border: 1px solid rgba(139,92,246,0.25); border-left: 4px solid #8b5cf6; border-radius: 14px; padding: 20px 22px; margin: 14px auto; max-width: 760px; transition: transform 0.2s; }
        .complaint-card:hover { transform: translateY(-2px); }
        .complaint-card.resolved { border-left-color: #3b82f6; }
        .complaint-card.closed   { border-left-color: #64748b; }
        .c-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px; }
        .c-subject { font-weight: 700; font-size: 15px; color: #f1f5f9; }
        .badge { padding: 4px 12px; border-radius: 12px; font-size: 11px; font-weight: 700; }
        .badge-open     { background: rgba(245,158,11,0.18); color: #fcd34d; border: 1px solid rgba(245,158,11,0.30); }
        .badge-resolved { background: rgba(59,130,246,0.18); color: #93c5fd; border: 1px solid rgba(59,130,246,0.30); }
        .badge-closed   { background: rgba(100,116,139,0.18); color: #94a3b8; border: 1px solid rgba(100,116,139,0.28); }
        .c-meta { font-size: 12px; color: #94a3b8; margin-bottom: 10px; }
        .c-message { color: #cbd5e1; font-size: 13px; margin-bottom: 10px; line-height: 1.6; background: rgba(15,10,40,0.40); padding: 10px 12px; border-radius: 7px; }
        .c-reply { background: rgba(139,92,246,0.14); border: 1px solid rgba(139,92,246,0.25); border-radius: 8px; padding: 12px 14px; font-size: 13px; color: #c4b5fd; margin-top: 10px; }
        .c-reply strong { display: block; margin-bottom: 5px; color: #a78bfa; }
        .add-btn { position: relative; z-index: 1; display: block; text-align: center; margin: 24px auto; }
        .add-btn a { background: linear-gradient(135deg,#7c3aed,#6d28d9); color: white; padding: 12px 28px; border-radius: 10px; text-decoration: none; font-size: 14px; font-weight: 700; box-shadow: 0 4px 14px rgba(124,58,237,0.40); transition: all 0.25s; }
        .add-btn a:hover { transform: translateY(-2px); box-shadow: 0 8px 20px rgba(124,58,237,0.55); }
        p[style*="color:#888"] { position: relative; z-index: 1; text-align: center; color: #94a3b8 !important; padding: 20px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>My Complaints</h2>
        <div>
            <a href="complaints.php">+ New Complaint</a>
            <a href="CustomerPage.php">Dashboard</a>
        </div>
    </div>

    <h2>My Complaints (<?php echo $total; ?>)</h2>

    <?php if ($total > 0): ?>
        <?php while ($c = mysqli_fetch_assoc($data)): ?>
        <div class="complaint-card <?php echo strtolower($c['status']); ?>">
            <div class="c-header">
                <span class="c-subject"><?php echo htmlspecialchars($c['subject']); ?></span>
                <?php
                $badgeClass = 'badge-open';
                if ($c['status'] === 'Resolved') $badgeClass = 'badge-resolved';
                if ($c['status'] === 'Closed')   $badgeClass = 'badge-closed';
                ?>
                <span class="badge <?php echo $badgeClass; ?>"><?php echo $c['status']; ?></span>
            </div>
            <div class="c-meta">Complaint #<?php echo $c['id']; ?> &mdash; <?php echo date('d M Y, h:i A', strtotime($c['created_at'])); ?></div>
            <div class="c-message"><?php echo nl2br(htmlspecialchars($c['message'])); ?></div>
            <?php if (!empty($c['admin_reply'])): ?>
            <div class="c-reply">
                <strong>Admin Response:</strong>
                <?php echo nl2br(htmlspecialchars($c['admin_reply'])); ?>
            </div>
            <?php endif; ?>
        </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p style="text-align:center;color:#888;">You have no complaints yet.</p>
        <div class="add-btn"><a href="complaints.php">Raise Your First Complaint</a></div>
    <?php endif; ?>
</body>
</html>
