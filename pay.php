<?php
session_start();
if (!isset($_SESSION['user_name'])) {
    header('Location: 1.customer.php');
    exit;
}
include("connection.php");

$userprofile = $_SESSION['user_name'];
$stmt = mysqli_prepare($conn, "SELECT * FROM form1 WHERE hname = ?");
mysqli_stmt_bind_param($stmt, "s", $userprofile);
mysqli_stmt_execute($stmt);
$result = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

$price = ($result['sename'] == 'Premium Pack') ? 650 : 450;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment - DIGI NETWORK</title>
    <style>
        body { background-image: url('remote.jpg'); font-family: Arial, sans-serif; margin: 0; padding: 0; background-size: cover; background-position: center; }
        .header { display: flex; justify-content: flex-end; padding: 10px 20px; }
        .header a { color: black; text-decoration: none; border: 1px solid black; padding: 8px 15px; border-radius: 5px; background: #f1f1f1; margin-left: 10px; }
        .header a:hover { background: #ddd; }
        .container2 { background: white; border: 2px solid black; width: 600px; margin: 20px auto; padding: 20px; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.1); }
        h1 { text-align: center; color: #4CAF50; }
        label { font-weight: bold; display: block; margin: 10px 0 4px; color: #333; }
        input, select { width: 95%; padding: 10px; border: 1px solid #ccc; border-radius: 5px; font-size: 15px; margin-bottom: 5px; }
        input:focus, select:focus { outline: none; border-color: #4CAF50; }
        .price-box { background: #f0f9f0; border: 1px solid #4CAF50; border-radius: 5px; padding: 12px; margin: 10px 0; text-align: center; font-size: 1.2rem; font-weight: bold; color: #2e7d32; }
        button { background: #4CAF50; color: white; padding: 12px; border: none; border-radius: 4px; cursor: pointer; font-size: 16px; width: 100%; margin-top: 10px; }
        button:hover { background: #45a049; }
        .info-box { background: #fff8e1; border-left: 4px solid #ffc107; padding: 12px; margin-top: 15px; font-size: 14px; line-height: 1.7; color: #555; }
    </style>
</head>
<body>
    <div class="header">
        <a href="CustomerPage.php">Return</a>
    </div>
    <div class="container2">
        <h1>Monthly Payment</h1>
        <form action="ment.php" method="POST">
            <label>UPI ID (Pay to)</label>
            <input type="text" name="Upi_name" value="saylicable99@okaxis" readonly>

            <label>Package</label>
            <input type="text" name="Package_name" value="<?php echo htmlspecialchars($result['sename']); ?>" readonly>

            <div class="price-box">
                Amount: Rs. <?php echo $price; ?>/-
            </div>

            <label>Select Month</label>
            <select name="month" required>
                <?php
                $months = ['01'=>'January','02'=>'February','03'=>'March','04'=>'April','05'=>'May','06'=>'June',
                           '07'=>'July','08'=>'August','09'=>'September','10'=>'October','11'=>'November','12'=>'December'];
                $curMonth = date('m');
                foreach ($months as $val => $label) {
                    $sel = ($val == $curMonth) ? 'selected' : '';
                    echo "<option value=\"$val\" $sel>$label</option>";
                }
                ?>
            </select>

            <label>Payment Mode</label>
            <select name="mode_name">
                <option value="Monthly">Monthly</option>
                <option value="Quarterly">Quarterly (3 months)</option>
                <option value="Annual">Annual (12 months)</option>
            </select>

            <label>Transaction ID</label>
            <input type="text" name="transaction_id" placeholder="Enter UPI Transaction ID" required>

            <div class="info-box">
                <strong>Payment Instructions:</strong><br>
                1. Pay on UPI ID: <strong>saylicable99@okaxis</strong><br>
                2. Note your Transaction ID after payment.<br>
                3. Enter Transaction ID above and submit.<br>
                4. For issues contact: <strong>9987452112</strong>
            </div>

            <button type="submit">Submit Payment</button>
        </form>
    </div>
</body>
</html>
