<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: updatecustomer.php');
    exit;
}
$Id = (int)$_GET['id'];
$error = '';

if (isset($_POST['register'])) {
    $cname   = trim($_POST['cname']);
    $sname   = trim($_POST['sname']);
    $pname   = trim($_POST['pname']);
    $selname = trim($_POST['selname']);
    $sename  = trim($_POST['sename']);
    $hname   = trim($_POST['hname']);
    $rname   = trim($_POST['rname']);

    $stmt = mysqli_prepare($conn, "UPDATE form1 SET cname=?, sname=?, pname=?, selname=?, sename=?, hname=?, rname=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssssssi", $cname, $sname, $pname, $selname, $sename, $hname, $rname, $Id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: updatecustomer.php');
        exit;
    } else {
        $error = 'Update failed. Please try again.';
    }
}

$stmt = mysqli_prepare($conn, "SELECT * FROM form1 WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $Id);
mysqli_stmt_execute($stmt);
$result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$result) {
    header('Location: updatecustomer.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Customer</title>
    <link rel="stylesheet" type="text/css" href="css/style4.css?v=2">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul><li><a href="updatecustomer.php">Return</a></li></ul>
        </div>
    </div>
    <div class="container">
        <form action="#" method="POST">
            <div class="title"><h1>EDIT CUSTOMER</h1></div>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>Email ID</label>
                    <input type="text" class="input" value="<?php echo htmlspecialchars($result['cname']); ?>" name="cname"
                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}" required>
                </div>
                <div class="input_field">
                    <label>STB-ID</label>
                    <input type="text" class="input" value="<?php echo htmlspecialchars($result['sname']); ?>" name="sname" pattern="\d{6}" required>
                </div>
                <div class="input_field">
                    <label>Phone Number</label>
                    <input type="text" class="input" value="<?php echo htmlspecialchars($result['pname']); ?>" name="pname" maxlength="12">
                </div>
                <div class="input_field">
                    <label>Area</label>
                    <select class="selectbox" name="selname" required>
                        <?php
                        $areas = ['ShivajiNagar','VijayNagar','Saradwadi','GaneshPeth','Panchpakadi','Khopat','Charai','Chandanwadi'];
                        foreach ($areas as $a) {
                            $sel = ($result['selname'] == $a) ? 'selected' : '';
                            echo "<option value=\"$a\" $sel>$a</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="input_field">
                    <label>Subscription</label>
                    <select class="selectbox" name="sename" required>
                        <option value="Premium Pack" <?php echo $result['sename']=='Premium Pack'?'selected':''; ?>>Premium Pack (HD) - Rs.650</option>
                        <option value="Gold Pack" <?php echo $result['sename']=='Gold Pack'?'selected':''; ?>>Gold Pack (SD) - Rs.450</option>
                    </select>
                </div>
                <div class="input_field">
                    <label>Username</label>
                    <input type="text" class="input" value="<?php echo htmlspecialchars($result['hname']); ?>" name="hname" required>
                </div>
                <div class="input_field">
                    <label>Password</label>
                    <input type="password" class="input" name="rname" placeholder="Enter new password" required>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" name="register">Update Customer</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
