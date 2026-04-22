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

// Handle update
if (isset($_POST['register'])) {
    $cname   = trim($_POST['cname']);
    $sname   = trim($_POST['sname']);
    $pname   = trim($_POST['pname']);
    $selname = trim($_POST['selname']);
    $sename  = trim($_POST['sename']);
    $hname   = trim($_POST['hname']);
    $rname   = trim($_POST['rname']);

    $stmt = mysqli_prepare($conn, "UPDATE form1 SET cname=?, sname=?, pname=?, selname=?, sename=?, hname=?, rname=? WHERE hname=?");
    mysqli_stmt_bind_param($stmt, "ssssssss", $cname, $sname, $pname, $selname, $sename, $hname, $rname, $userprofile);
    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['user_name'] = $hname;
        header('Location: customerdetails.php');
        exit;
    } else {
        $error = 'Update failed. Please try again.';
    }
}

// Fetch current data
$stmt = mysqli_prepare($conn, "SELECT * FROM form1 WHERE hname = ?");
mysqli_stmt_bind_param($stmt, "s", $userprofile);
mysqli_stmt_execute($stmt);
$result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Update My Details</title>
    <link rel="stylesheet" type="text/css" href="style4.css">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul>
                <li><a href="CustomerPage.php">Return</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <form action="#" method="POST">
            <div class="title">
                <h1>UPDATE YOUR DETAILS</h1>
            </div>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>Email ID</label>
                    <input type="text" class="input" value="<?php echo htmlspecialchars($result['cname']); ?>" name="cname" required>
                </div>
                <div class="input_field">
                    <label>STB-ID</label>
                    <input type="text" class="input" value="<?php echo htmlspecialchars($result['sname']); ?>" name="sname" required>
                </div>
                <div class="input_field">
                    <label>Phone Number</label>
                    <input type="text" class="input" value="<?php echo htmlspecialchars($result['pname']); ?>" name="pname">
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
                        <option value="Premium Pack" <?php echo $result['sename']=='Premium Pack'?'selected':''; ?>>Premium Pack - Rs. 650/month (HD)</option>
                        <option value="Gold Pack" <?php echo $result['sename']=='Gold Pack'?'selected':''; ?>>Gold Pack - Rs. 450/month (SD)</option>
                    </select>
                </div>
                <div class="input_field">
                    <label>Username</label>
                    <input type="text" class="input" name="hname" value="<?php echo htmlspecialchars($result['hname']); ?>" required>
                </div>
                <div class="input_field">
                    <label>New Password</label>
                    <input type="password" class="input" name="rname" placeholder="Enter new password" required>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" name="register">Update</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
