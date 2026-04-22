<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: worker.php');
    exit;
}
$id    = (int)$_GET['id'];
$error = '';

if (isset($_POST['register'])) {
    $sname = trim($_POST['sname']);
    $uname = trim($_POST['uname']);
    $dname = trim($_POST['dname']);
    $hname = (int)$_POST['hname'];

    $stmt = mysqli_prepare($conn, "UPDATE form6 SET sname=?, uname=?, dname=?, hname=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "sssii", $sname, $uname, $dname, $hname, $id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: worker.php');
        exit;
    } else {
        $error = 'Update failed. Please try again.';
    }
}

$stmt = mysqli_prepare($conn, "SELECT * FROM form6 WHERE id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

if (!$result) {
    header('Location: worker.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit Worker</title>
    <link rel="stylesheet" type="text/css" href="css/style4.css">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul><li><a href="worker.php">Return</a></li></ul>
        </div>
    </div>
    <div class="container">
        <form action="#" method="POST">
            <div class="title"><h1>EDIT WORKER</h1></div>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>Name</label>
                    <input type="text" class="input" name="sname" value="<?php echo htmlspecialchars($result['sname']); ?>" required>
                </div>
                <div class="input_field">
                    <label>Phone Number</label>
                    <input type="text" class="input" name="uname" value="<?php echo htmlspecialchars($result['uname']); ?>" required>
                </div>
                <div class="input_field">
                    <label>Designation</label>
                    <select class="selectbox" name="dname" required>
                        <?php
                        $designations = ['Technician','Mechanic','Office Staff','Field Engineer','Supervisor'];
                        foreach ($designations as $d) {
                            $sel = ($result['dname'] == $d || strtolower($result['dname']) == strtolower($d)) ? 'selected' : '';
                            echo "<option value=\"$d\" $sel>$d</option>";
                        }
                        if (!in_array($result['dname'], $designations)) {
                            echo "<option value=\"{$result['dname']}\" selected>{$result['dname']}</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="input_field">
                    <label>Salary (Rs.)</label>
                    <input type="number" class="input" name="hname" value="<?php echo $result['hname']; ?>" min="0" required>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" name="register">Update Worker</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
