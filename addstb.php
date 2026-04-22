<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

$error   = '';
$success = '';

// Fetch customers for assignment dropdown
$customers = mysqli_query($conn, "SELECT id, hname, sname FROM form1 ORDER BY hname");

if (isset($_POST['submit'])) {
    $stb_number   = trim($_POST['stb_number']);
    $brand        = trim($_POST['brand']);
    $model        = trim($_POST['model']);
    $status       = trim($_POST['status']);
    $assigned_id  = $_POST['assigned_customer_id'] !== '' ? (int)$_POST['assigned_customer_id'] : null;
    $added_date   = trim($_POST['added_date']);

    if ($status === 'Assigned' && !$assigned_id) {
        $error = 'Please select a customer to assign this STB to.';
    } elseif (empty($stb_number) || empty($brand) || empty($model)) {
        $error = 'STB Number, Brand and Model are required.';
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO stb_inventory (stb_number, brand, model, assigned_customer_id, status, added_date) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssiss", $stb_number, $brand, $model, $assigned_id, $status, $added_date);
        if (mysqli_stmt_execute($stmt)) {
            header('Location: stb.php');
            exit;
        } else {
            $error = 'Failed to add STB. STB Number may already exist.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Add STB</title>
    <link rel="stylesheet" type="text/css" href="css/style4.css?v=2">
</head>
<body>
    <div class="header">
        <div class="navbar">
            <ul><li><a href="stb.php">Return</a></li></ul>
        </div>
    </div>
    <div class="container">
        <form method="POST">
            <div class="title"><h1>ADD STB</h1></div>
            <?php if ($error): ?>
                <p style="color:red;text-align:center;"><?php echo htmlspecialchars($error); ?></p>
            <?php endif; ?>
            <div class="form">
                <div class="input_field">
                    <label>STB Number (unique)</label>
                    <input type="text" class="input" name="stb_number" placeholder="e.g. STB-001234" required>
                </div>
                <div class="input_field">
                    <label>Brand</label>
                    <select class="selectbox" name="brand" required>
                        <option value="">Select Brand</option>
                        <option value="Airtel">Airtel</option>
                        <option value="Tata Play">Tata Play</option>
                        <option value="Dish TV">Dish TV</option>
                        <option value="Sun Direct">Sun Direct</option>
                        <option value="Videocon">Videocon</option>
                        <option value="Other">Other</option>
                    </select>
                </div>
                <div class="input_field">
                    <label>Model</label>
                    <input type="text" class="input" name="model" placeholder="e.g. HD-4K-V2" required>
                </div>
                <div class="input_field">
                    <label>Status</label>
                    <select class="selectbox" name="status" id="statusSel" onchange="toggleAssign()" required>
                        <option value="Available">Available</option>
                        <option value="Assigned">Assigned to Customer</option>
                    </select>
                </div>
                <div class="input_field" id="assignDiv" style="display:none;">
                    <label>Assign to Customer</label>
                    <select class="selectbox" name="assigned_customer_id">
                        <option value="">Select Customer</option>
                        <?php while ($c = mysqli_fetch_assoc($customers)): ?>
                        <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['hname']); ?> (STB: <?php echo $c['sname']; ?>)</option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="input_field">
                    <label>Date Added</label>
                    <input type="date" class="input" name="added_date" value="<?php echo date('Y-m-d'); ?>">
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" name="submit">Add STB</button>
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
