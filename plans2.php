<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

$error   = '';
$success = '';

if (isset($_POST['register'])) {
    $mname = trim($_POST['mname']);
    $aname = trim($_POST['aname']);
    $yname = trim($_POST['yname']);
    $uname = trim($_POST['uname']);

    if (empty($mname) || empty($aname) || empty($yname) || empty($uname)) {
        $error = 'All fields are required.';
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO form5 (mname, aname, yname, uname) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $mname, $aname, $yname, $uname);
        if (mysqli_stmt_execute($stmt)) {
            $success = 'Channel added successfully.';
        } else {
            $error = 'Failed to add channel.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Premium Pack Channel</title>
<<<<<<< HEAD
    <link rel="stylesheet" type="text/css" href="css/style4.css?v=2">
=======
    <link rel="stylesheet" type="text/css" href="style4.css">
>>>>>>> f4d76211c5e28b18bc4efdae812dc17bf57f688c
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul><li><a href="PP.php">Return</a></li></ul>
        </div>
    </div>
    <div class="container">
        <form method="POST">
            <div class="title"><h1>ADD PREMIUM PACK CHANNEL</h1></div>
            <?php if ($success): ?>
                <p style="color:green;text-align:center;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>Channel Name</label>
                    <input type="text" class="input" name="mname" placeholder="e.g. Sony HD" required>
                </div>
                <div class="input_field">
                    <label>Channel Code</label>
                    <input type="text" class="input" name="aname" placeholder="e.g. 1001" required>
                </div>
                <div class="input_field">
                    <label>Price (Rs.)</label>
                    <input type="number" class="input" name="yname" min="0" placeholder="e.g. 15" required>
                </div>
                <div class="input_field">
                    <label>Quality</label>
                    <select class="selectbox" name="uname" required>
                        <option value="HD Pack">HD Pack</option>
                        <option value="SD Pack">SD Pack</option>
                    </select>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" name="register">Add Channel</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
