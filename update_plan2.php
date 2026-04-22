<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: displayplan2.php');
    exit;
}
$id    = (int)$_GET['id'];
$error = '';

if (isset($_POST['update'])) {
    $mname = trim($_POST['mname']);
    $aname = trim($_POST['aname']);
    $yname = trim($_POST['yname']);
    $uname = trim($_POST['uname']);

    $stmt = mysqli_prepare($conn, "UPDATE form5 SET mname=?, aname=?, yname=?, uname=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssi", $mname, $aname, $yname, $uname, $id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: displayplan2.php');
        exit;
    } else {
        $error = 'Update failed.';
    }
}

$stmt = mysqli_prepare($conn, "SELECT * FROM form5 WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$result) {
    header('Location: displayplan2.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Premium Pack Channel</title>
    <link rel="stylesheet" type="text/css" href="style4.css">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul><li><a href="displayplan2.php">Return</a></li></ul>
        </div>
    </div>
    <div class="container">
        <form action="#" method="POST">
            <div class="title"><h1>EDIT HD CHANNEL</h1></div>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>Channel Name</label>
                    <input type="text" class="input" name="mname" value="<?php echo htmlspecialchars($result['mname']); ?>" required>
                </div>
                <div class="input_field">
                    <label>Channel Code</label>
                    <input type="text" class="input" name="aname" value="<?php echo htmlspecialchars($result['aname']); ?>" required>
                </div>
                <div class="input_field">
                    <label>Price (Rs.)</label>
                    <input type="number" class="input" name="yname" value="<?php echo $result['yname']; ?>">
                </div>
                <div class="input_field">
                    <label>Quality</label>
                    <select class="selectbox" name="uname" required>
                        <option value="HD Pack" <?php echo $result['uname']==='HD Pack'?'selected':''; ?>>HD Pack</option>
                        <option value="SD Pack" <?php echo $result['uname']==='SD Pack'?'selected':''; ?>>SD Pack</option>
                    </select>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" name="update">Update Channel</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
