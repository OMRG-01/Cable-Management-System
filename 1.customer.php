<?php
session_start();
if (isset($_SESSION['user_name'])) {
    header('Location: CustomerPage.php');
    exit;
}
$error = '';
if (isset($_POST['register'])) {
    include("connection.php");
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $stmt = mysqli_prepare($conn, "SELECT id, hname FROM form1 WHERE hname = ? AND rname = ?");
    mysqli_stmt_bind_param($stmt, "ss", $username, $password);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    if (mysqli_num_rows($result) === 1) {
        $_SESSION['user_name'] = $username;
        header('Location: CustomerPage.php');
        exit;
    } else {
        $error = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DIGI NETWORK - Customer Login</title>
    <link rel="stylesheet" type="text/css" href="css/style4.css?v=2">
</head>
<body>
    <div class="container">
        <form method="POST" autocomplete="off">
            <div class="title">
                <h1>DIGI NETWORK</h1>
            </div>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>Username</label>
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
        <div class="flex">
            <form action="operator.php" class="flex-item">
                <button class="button">Admin Page</button>
            </form>
            <form action="newregister.php" class="flex-item">
                <button class="button">New Registration</button>
            </form>
            <form action="connection_request.php" class="flex-item">
                <button class="button">Apply for Connection</button>
            </form>
        </div>
    </div>
</body>
</html>
