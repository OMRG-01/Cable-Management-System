<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: 1.customer.php');
    exit;
}
include("connection.php");

$userprofile = $_SESSION['user_name'];
$error   = '';
$success = '';

// Get user_id
$s = mysqli_prepare($conn, "SELECT id FROM form1 WHERE hname=?");
mysqli_stmt_bind_param($s, "s", $userprofile);
mysqli_stmt_execute($s);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($s));
$user_id = $row['id'];

if (isset($_POST['submit'])) {
    $subject = trim($_POST['subject']);
    $message = trim($_POST['message']);

    if (empty($subject) || empty($message)) {
        $error = 'Subject and message are required.';
    } else {
        $ins = mysqli_prepare($conn, "INSERT INTO complaints (user_id, username, subject, message) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($ins, "isss", $user_id, $userprofile, $subject, $message);
        if (mysqli_stmt_execute($ins)) {
            $success = 'Your complaint has been submitted successfully.';
        } else {
            $error = 'Failed to submit complaint. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Raise Complaint</title>
    <style>
<<<<<<< HEAD
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; background-image: url('maincable.png'); background-size: cover; background-position: center; background-attachment: fixed; min-height: 100vh; position: relative; }
        body::before { content: ''; position: fixed; inset: 0; background: linear-gradient(135deg, rgba(26,5,51,0.82) 0%, rgba(45,27,105,0.75) 100%); z-index: 0; }
        .header { position: relative; z-index: 10; background: rgba(15,10,40,0.92); backdrop-filter: blur(14px); padding: 14px 24px; display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid rgba(139,92,246,0.25); }
        .header h2 { margin: 0; font-size: 16px; font-weight: 700; color: white; }
        .header a { color: rgba(255,255,255,0.80); text-decoration: none; border: 1px solid rgba(139,92,246,0.40); padding: 7px 16px; border-radius: 8px; font-size: 13px; font-weight: 600; margin-left: 8px; transition: all 0.25s; }
        .header a:hover { background: #8b5cf6; border-color: #8b5cf6; color: white; }
        .container { position: relative; z-index: 1; max-width: 640px; margin: 36px auto; background: rgba(255,255,255,0.06); backdrop-filter: blur(20px); border: 1px solid rgba(255,255,255,0.13); padding: 36px 34px; border-radius: 18px; box-shadow: 0 20px 45px rgba(0,0,0,0.40); }
        h1 { color: white; text-align: center; margin-top: 0; margin-bottom: 24px; font-size: 1.5rem; font-weight: 700; }
        label { display: block; margin: 14px 0 5px; font-size: 11px; font-weight: 700; color: rgba(255,255,255,0.68); text-transform: uppercase; letter-spacing: 0.7px; }
        select, textarea { width: 100%; padding: 11px 14px; background: rgba(255,255,255,0.08); border: 1px solid rgba(255,255,255,0.18); border-radius: 9px; color: white; font-size: 14px; font-family: inherit; box-sizing: border-box; outline: none; transition: all 0.25s; }
        select option { background: #1e1b4b; color: white; }
        textarea { height: 120px; resize: vertical; }
        select:focus, textarea:focus { border-color: #8b5cf6; box-shadow: 0 0 0 3px rgba(139,92,246,0.22); }
        button { background: linear-gradient(135deg, #7c3aed, #6d28d9); color: white; padding: 13px 25px; border: none; border-radius: 10px; cursor: pointer; font-size: 15px; font-weight: 700; font-family: inherit; width: 100%; margin-top: 18px; transition: all 0.25s; box-shadow: 0 4px 16px rgba(124,58,237,0.40); }
        button:hover { transform: translateY(-2px); box-shadow: 0 8px 22px rgba(124,58,237,0.55); }
        .msg-ok  { background: rgba(16,185,129,0.15); border-left: 4px solid #10b981; padding: 11px 14px; margin-bottom: 16px; color: #6ee7b7; border-radius: 6px; font-size: 13px; }
        .msg-err { background: rgba(239,68,68,0.15); border-left: 4px solid #ef4444; padding: 11px 14px; margin-bottom: 16px; color: #fca5a5; border-radius: 6px; font-size: 13px; }
        .view-link { text-align: center; margin-top: 18px; }
        .view-link a { color: #a78bfa; font-size: 14px; text-decoration: none; font-weight: 500; }
        .view-link a:hover { color: white; }
=======
        body { font-family: Arial, sans-serif; background: #f0f4f8; margin: 0; }
        .header { background: #2e7d32; color: white; padding: 12px 20px; display: flex; justify-content: space-between; align-items: center; }
        .header h2 { margin: 0; font-size: 1.2rem; }
        .header a { color: white; text-decoration: none; border: 1px solid #fff; padding: 6px 14px; border-radius: 5px; font-size: 13px; }
        .header a:hover { background: rgba(255,255,255,0.2); }
        .container { max-width: 620px; margin: 30px auto; background: white; padding: 30px; border-radius: 10px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        h1 { color: #2e7d32; text-align: center; margin-top: 0; }
        label { display: block; margin: 12px 0 4px; font-weight: bold; color: #333; }
        input[type=text], select, textarea { width: 100%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 14px; box-sizing: border-box; }
        textarea { height: 120px; resize: vertical; }
        input:focus, select:focus, textarea:focus { outline: none; border-color: #4CAF50; }
        button { background: #2e7d32; color: white; padding: 11px 25px; border: none; border-radius: 5px; cursor: pointer; font-size: 15px; width: 100%; margin-top: 15px; }
        button:hover { background: #1b5e20; }
        .msg-ok  { background: #e8f5e9; border-left: 4px solid #4CAF50; padding: 10px 14px; margin-bottom: 15px; color: #2e7d32; border-radius: 4px; }
        .msg-err { background: #fce4ec; border-left: 4px solid #e53935; padding: 10px 14px; margin-bottom: 15px; color: #c62828; border-radius: 4px; }
        .view-link { text-align: center; margin-top: 15px; }
        .view-link a { color: #2e7d32; font-size: 14px; }
>>>>>>> f4d76211c5e28b18bc4efdae812dc17bf57f688c
    </style>
</head>
<body>
    <div class="header">
        <h2>DIGI NETWORK - Complaints</h2>
        <div>
            <a href="viewcomplaints.php">My Complaints</a>
            &nbsp;
            <a href="CustomerPage.php">Dashboard</a>
        </div>
    </div>
    <div class="container">
        <h1>Raise a Complaint</h1>
        <?php if ($success): ?>
            <div class="msg-ok"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="msg-err"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>
        <form method="POST">
            <label>Complaint Category</label>
            <select name="subject" required>
                <option value="">Select Category</option>
                <option value="No Signal">No Signal</option>
                <option value="Poor Picture Quality">Poor Picture Quality</option>
                <option value="Set-Top Box Issue">Set-Top Box Issue</option>
                <option value="Payment Issue">Payment Issue</option>
                <option value="Channel Not Available">Channel Not Available</option>
                <option value="Connection Issue">Connection Issue</option>
                <option value="Other">Other</option>
            </select>

            <label>Describe Your Issue</label>
            <textarea name="message" placeholder="Please describe your issue in detail..." required></textarea>

            <button type="submit" name="submit">Submit Complaint</button>
        </form>
        <div class="view-link">
            <a href="viewcomplaints.php">View my previous complaints &rarr;</a>
        </div>
    </div>
</body>
</html>
