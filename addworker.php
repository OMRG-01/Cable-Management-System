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
    $sname = trim($_POST['sname']);
    $uname = trim($_POST['uname']);
    $dname = trim($_POST['dname']);
    $hname = (int)$_POST['hname'];

    if (empty($sname) || empty($uname) || empty($dname)) {
        $error = 'All fields are required.';
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO form6 (sname, uname, dname, hname, iname) VALUES (?, ?, ?, ?, '')");
        mysqli_stmt_bind_param($stmt, "sssi", $sname, $uname, $dname, $hname);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: worker.php');
            exit;
        } else {
            $error = 'Failed to add worker.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add Worker</title>
    <link rel="stylesheet" type="text/css" href="css/style4.css?v=2">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul><li><a href="worker.php">Return</a></li></ul>
        </div>
    </div>
    <div class="container">
        <form method="POST">
            <div class="title"><h1>ADD WORKER</h1></div>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>Full Name</label>
                    <input type="text" class="input" name="sname" placeholder="e.g. Mohan Singh" required>
                </div>
                <div class="input_field">
                    <label>Phone Number</label>
                    <input type="text" class="input" name="uname" pattern="\d{10}" maxlength="10" placeholder="10-digit number" required>
                </div>
                <div class="input_field">
                    <label>Designation</label>
                    <select class="selectbox" name="dname" required>
                        <option value="">Select Designation</option>
                        <option value="Technician">Technician</option>
                        <option value="Mechanic">Mechanic</option>
                        <option value="Office Staff">Office Staff</option>
                        <option value="Field Engineer">Field Engineer</option>
                        <option value="Supervisor">Supervisor</option>
                    </select>
                </div>
                <div class="input_field">
                    <label>Salary (Rs.)</label>
                    <input type="number" class="input" name="hname" min="0" placeholder="e.g. 9000" required>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" name="register">Add Worker</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
