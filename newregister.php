<?php
include("connection.php");
$error   = '';
$success = '';

if (isset($_POST['register'])) {
    $cname   = trim($_POST['cname']);
    $sname   = trim($_POST['sname']);
    $pname   = trim($_POST['pname']);
    $selname = trim($_POST['selname']);
    $sename  = trim($_POST['sename']);
    $hname   = trim($_POST['hname']);
    $rname   = trim($_POST['rname']);

    if (empty($cname) || empty($sname) || empty($pname) || empty($selname) || empty($sename) || empty($hname) || empty($rname)) {
        $error = 'All fields are required.';
    } else {
        // Check for duplicate username or STB-ID
        $chk = mysqli_prepare($conn, "SELECT id FROM form1 WHERE hname = ? OR sname = ?");
        mysqli_stmt_bind_param($chk, "ss", $hname, $sname);
        mysqli_stmt_execute($chk);
        mysqli_stmt_store_result($chk);
        if (mysqli_stmt_num_rows($chk) > 0) {
            $error = 'Username or STB-ID already registered. Please use different values.';
        } else {
            $stmt = mysqli_prepare($conn, "INSERT INTO form1 (cname, sname, pname, selname, sename, hname, rname) VALUES (?, ?, ?, ?, ?, ?, ?)");
            mysqli_stmt_bind_param($stmt, "sssssss", $cname, $sname, $pname, $selname, $sename, $hname, $rname);
            if (mysqli_stmt_execute($stmt)) {
                $success = 'Registration successful! You can now login.';
            } else {
                $error = 'Registration failed. Please try again.';
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>New Registration</title>
    <link rel="stylesheet" type="text/css" href="css/style9.css?v=2">
</head>
<body>
    <div class="container">
        <form method="POST" autocomplete="off">
            <div class="title">
                <h1>NEW REGISTRATION</h1>
            </div>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <?php if ($success): ?>
                <p style="color:green;text-align:center;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>Email ID</label>
                    <input type="text" class="input" name="cname"
                        pattern="[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}"
                        title="Enter a valid email address" required>
                </div>
                <div class="input_field">
                    <label>STB-ID</label>
                    <input type="text" class="input" name="sname"
                        pattern="\d{6}" placeholder="6-digit number e.g. 123456" required>
                </div>
                <div class="input_field">
                    <label>Phone Number</label>
                    <input type="text" class="input" name="pname"
                        pattern="\d{10}" maxlength="10" placeholder="10-digit number" required>
                </div>
                <div class="input_field">
                    <label>Area</label>
                    <select class="selectbox" name="selname" required>
                        <option value="">Select Area</option>
                        <option value="ShivajiNagar">Shivaji Nagar</option>
                        <option value="VijayNagar">Vijay Nagar</option>
                        <option value="Saradwadi">Saradwadi</option>
                        <option value="GaneshPeth">Ganesh Peth</option>
                        <option value="Panchpakadi">Panchpakadi</option>
                        <option value="Khopat">Khopat</option>
                        <option value="Charai">Charai</option>
                        <option value="Chandanwadi">Chandanwadi</option>
                    </select>
                </div>
                <div class="input_field">
                    <label>Subscription</label>
                    <select class="selectbox" name="sename" required>
                        <option value="">Select Plan</option>
                        <option value="Premium Pack">Premium Pack - Rs. 650/month (HD)</option>
                        <option value="Gold Pack">Gold Pack - Rs. 450/month (SD)</option>
                    </select>
                </div>
                <div class="input_field">
                    <label>Set Username</label>
                    <input type="text" class="input" name="hname"
                        placeholder="e.g. john@123" required>
                </div>
                <div class="input_field">
                    <label>Password</label>
                    <input type="password" class="input" name="rname"
                        placeholder="Min 8 chars, upper+lower+number+special"
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
                        title="Min 8 chars with uppercase, lowercase, number and special character" required>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" name="register">Register</button>
                </div>
            </div>
        </form>
        <div class="flex">
            <form action="1.customer.php" class="flex-item">
                <button class="button">Back to Login</button>
            </form>
        </div>
    </div>
</body>
</html>
