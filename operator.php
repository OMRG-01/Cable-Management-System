<?php
session_start();
if (isset($_SESSION['admin_name'])) {
    header('Location: dashboard.php');
    exit;
}
$error = '';
if (isset($_POST['register'])) {
    include("connection.php");
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $stmt = mysqli_prepare($conn, "SELECT user FROM form4 WHERE user = ? AND pass = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) === 1) {
        $_SESSION['admin_name'] = $username;
        header('Location: dashboard.php');
        exit;
    } else {
        $error = 'Invalid admin credentials.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Login</title>
    <link rel="stylesheet" type="text/css" href="css/style4.css?v=2">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul>
                <li><a href="1.customer.php">Home</a></li>
            </ul>
        </div>
    </div>
    <div class="container">
        <form method="POST" autocomplete="off">
            <div class="title">
                <h1>Admin Login</h1>
            </div>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>Operator ID</label>
                    <input type="text" class="input" name="username" required>
                </div>
                <div class="input_field">
                    <label>Password</label>
                    <input type="password" class="input" name="password" required>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" name="register">Login</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
