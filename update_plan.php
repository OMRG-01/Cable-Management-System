<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: displayplan.php');
    exit;
}
$id    = (int)$_GET['id'];
$error = '';

if (isset($_POST['register'])) {
    $plname = trim($_POST['plname']);
    $pcname = trim($_POST['pcname']);
    $prname = trim($_POST['prname']);
    $qname  = trim($_POST['qname']);

    $stmt = mysqli_prepare($conn, "UPDATE form2 SET plname=?, pcname=?, prname=?, qname=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssssi", $plname, $pcname, $prname, $qname, $id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: displayplan.php');
        exit;
    } else {
        $error = 'Update failed.';
    }
}

$stmt = mysqli_prepare($conn, "SELECT * FROM form2 WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$result) {
    header('Location: displayplan.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Gold Pack Channel</title>
    <link rel="stylesheet" type="text/css" href="css/style4.css?v=2">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul><li><a href="displayplan.php">Return</a></li></ul>
        </div>
    </div>
    <div class="container">
        <form action="#" method="POST">
            <div class="title"><h1>EDIT CHANNEL</h1></div>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>Channel Name</label>
                    <input type="text" class="input" name="plname" value="<?php echo htmlspecialchars($result['plname']); ?>" required>
                </div>
                <div class="input_field">
                    <label>Channel Code</label>
                    <input type="text" class="input" name="pcname" value="<?php echo htmlspecialchars($result['pcname']); ?>" required>
                </div>
                <div class="input_field">
                    <label>Price (Rs.)</label>
                    <input type="number" class="input" name="prname" value="<?php echo $result['prname']; ?>">
                </div>
                <div class="input_field">
                    <label>Quality</label>
                    <select class="selectbox" name="qname" required>
                        <option value="SD Pack" <?php echo $result['qname']==='SD Pack'?'selected':''; ?>>SD Pack</option>
                        <option value="HD Pack" <?php echo $result['qname']==='HD Pack'?'selected':''; ?>>HD Pack</option>
                    </select>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" name="register">Update Channel</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
