<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: stb.php');
    exit;
}
$id    = (int)$_GET['id'];
$error = '';

$customers = mysqli_query($conn, "SELECT id, hname, sname FROM form1 ORDER BY hname");

if (isset($_POST['submit'])) {
    $stb_number  = trim($_POST['stb_number']);
    $brand       = trim($_POST['brand']);
    $model       = trim($_POST['model']);
    $status      = trim($_POST['status']);
    $assigned_id = $_POST['assigned_customer_id'] !== '' ? (int)$_POST['assigned_customer_id'] : null;
    $added_date  = trim($_POST['added_date']);

    $stmt = mysqli_prepare($conn, "UPDATE stb_inventory SET stb_number=?, brand=?, model=?, assigned_customer_id=?, status=?, added_date=? WHERE id=?");
    mysqli_stmt_bind_param($stmt, "ssisssi", $stb_number, $brand, $model, $assigned_id, $status, $added_date, $id);
    if (mysqli_stmt_execute($stmt)) {
        header('Location: stb.php');
        exit;
    } else {
        $error = 'Update failed. STB Number may already be in use.';
    }
}

$sel = mysqli_prepare($conn, "SELECT * FROM stb_inventory WHERE id=?");
mysqli_stmt_bind_param($sel, "i", $id);
mysqli_stmt_execute($sel);
$stb = mysqli_fetch_assoc(mysqli_stmt_get_result($sel));

if (!$stb) {
    header('Location: stb.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Edit STB</title>
<<<<<<< HEAD
    <link rel="stylesheet" type="text/css" href="css/style4.css?v=2">
=======
    <link rel="stylesheet" type="text/css" href="css/style4.css">
>>>>>>> f4d76211c5e28b18bc4efdae812dc17bf57f688c
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul><li><a href="stb.php">Return</a></li></ul>
        </div>
    </div>
    <div class="container">
        <form method="POST">
            <div class="title"><h1>EDIT STB</h1></div>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>STB Number</label>
                    <input type="text" class="input" name="stb_number" value="<?php echo htmlspecialchars($stb['stb_number']); ?>" required>
                </div>
                <div class="input_field">
                    <label>Brand</label>
                    <select class="selectbox" name="brand" required>
                        <?php
                        $brands = ['Airtel','Tata Play','Dish TV','Sun Direct','Videocon','Other'];
                        foreach ($brands as $b) {
                            $sel2 = ($stb['brand']==$b)?'selected':'';
                            echo "<option value=\"$b\" $sel2>$b</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="input_field">
                    <label>Model</label>
                    <input type="text" class="input" name="model" value="<?php echo htmlspecialchars($stb['model']); ?>" required>
                </div>
                <div class="input_field">
                    <label>Status</label>
                    <select class="selectbox" name="status" id="statusSel" onchange="toggleAssign()">
                        <option value="Available" <?php echo $stb['status']==='Available'?'selected':''; ?>>Available</option>
                        <option value="Assigned"  <?php echo $stb['status']==='Assigned'?'selected':''; ?>>Assigned to Customer</option>
                    </select>
                </div>
                <div class="input_field" id="assignDiv" style="<?php echo $stb['status']==='Assigned'?'':'display:none'; ?>">
                    <label>Assign to Customer</label>
                    <select class="selectbox" name="assigned_customer_id">
                        <option value="">None</option>
                        <?php while ($c = mysqli_fetch_assoc($customers)): ?>
                        <option value="<?php echo $c['id']; ?>" <?php echo ($stb['assigned_customer_id']==$c['id'])?'selected':''; ?>>
                            <?php echo htmlspecialchars($c['hname']); ?> (STB: <?php echo $c['sname']; ?>)
                        </option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="input_field">
                    <label>Date Added</label>
                    <input type="date" class="input" name="added_date" value="<?php echo $stb['added_date']; ?>">
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" name="submit">Update STB</button>
                </div>
            </div>
        </form>
    </div>
    <script>
        function toggleAssign() {
            document.getElementById('assignDiv').style.display =
                document.getElementById('statusSel').value === 'Assigned' ? 'block' : 'none';
        }
    </script>
</body>
</html>
