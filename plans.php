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
    $plname = trim($_POST['plname']);
    $pcname = trim($_POST['pcname']);
    $prname = trim($_POST['prname']);
    $qname  = trim($_POST['qname']);

    if (empty($plname) || empty($pcname) || empty($prname) || empty($qname)) {
        $error = 'All fields are required.';
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO form2 (plname, pcname, prname, qname) VALUES (?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssss", $plname, $pcname, $prname, $qname);
        if (mysqli_stmt_execute($stmt)) {
            $success = 'Plan added successfully.';
        } else {
            $error = 'Failed to add plan.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Gold Pack Channel</title>
    <link rel="stylesheet" type="text/css" href="style4.css">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul><li><a href="PP.php">Return</a></li></ul>
        </div>
    </div>
    <div class="container">
        <form action="#" method="POST">
            <div class="title"><h1>ADD GOLD PACK CHANNEL</h1></div>
            <?php if ($success): ?>
                <p style="color:green;text-align:center;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>Channel Name</label>
                    <input type="text" class="input" name="plname" placeholder="e.g. Sony Max" required>
                </div>
                <div class="input_field">
                    <label>Channel Code</label>
                    <input type="text" class="input" name="pcname" placeholder="e.g. 1011" required>
                </div>
                <div class="input_field">
                    <label>Price (Rs.)</label>
                    <input type="number" class="input" name="prname" min="0" placeholder="e.g. 10" required>
                </div>
                <div class="input_field">
                    <label>Quality</label>
                    <select class="selectbox" name="qname" required>
                        <option value="">Select</option>
                        <option value="SD Pack">SD Pack</option>
                        <option value="HD Pack">HD Pack</option>
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
