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
        body { font-family: Arial, sans-serif; background: #f0f4f8; margin: 0; }
        .header { background: #2e7d32; color: white; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h2 { margin: 0; font-size: 1.2rem; }
        .header a { color: white; text-decoration: none; border: 1px solid #fff; padding: 6px 14px; border-radius: 5px; font-size: 13px; margin-left: 8px; }
        .header a:hover { background: rgba(255,255,255,0.2); }
        h2 { text-align: center; color: #2e7d32; }
        .complaint-card { background: white; border-radius: 8px; padding: 18px 22px; margin: 15px auto; max-width: 750px; box-shadow: 0 2px 8px rgba(0,0,0,0.08); border-left: 4px solid #4CAF50; }
        .complaint-card.resolved { border-left-color: #2196F3; }
        .complaint-card.closed   { border-left-color: #9e9e9e; }
        .c-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .c-subject { font-weight: bold; font-size: 1rem; color: #333; }
        .badge { padding: 3px 12px; border-radius: 12px; font-size: 12px; font-weight: bold; }
        .badge-open     { background: #fff8e1; color: #f57f17; border: 1px solid #ffc107; }
        .badge-resolved { background: #e3f2fd; color: #1565c0; border: 1px solid #2196F3; }
        .badge-closed   { background: #f5f5f5; color: #757575; border: 1px solid #9e9e9e; }
        .c-meta { font-size: 12px; color: #888; margin-bottom: 8px; }
        .c-message { color: #444; font-size: 14px; margin-bottom: 8px; }
        .c-reply { background: #e8f5e9; border-radius: 5px; padding: 10px; font-size: 13px; color: #2e7d32; margin-top: 8px; }
        .c-reply strong { display: block; margin-bottom: 4px; }
        .add-btn { display: block; text-align: center; margin: 20px auto; }
        .add-btn a { background: #2e7d32; color: white; padding: 10px 25px; border-radius: 5px; text-decoration: none; font-size: 14px; }
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
