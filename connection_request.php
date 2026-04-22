<?php
// Accessible without login - for new customers wanting to apply
include("connection.php");

$error   = '';
$success = '';

if (isset($_POST['submit'])) {
    $full_name         = trim($_POST['full_name']);
    $email             = trim($_POST['email']);
    $phone             = trim($_POST['phone']);
    $address           = trim($_POST['address']);
    $area              = trim($_POST['area']);
    $subscription_type = trim($_POST['subscription_type']);

    if (empty($full_name) || empty($email) || empty($phone) || empty($address) || empty($area) || empty($subscription_type)) {
        $error = 'All fields are required.';
    } else {
        $stmt = mysqli_prepare($conn, "INSERT INTO connection_requests (full_name, email, phone, address, area, subscription_type) VALUES (?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "ssssss", $full_name, $email, $phone, $address, $area, $subscription_type);
        if (mysqli_stmt_execute($stmt)) {
            $success = 'Your connection request has been submitted! Our team will contact you within 2 working days.';
        } else {
            $error = 'Failed to submit request. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Connection Request - DIGI NETWORK</title>
    <style>
        body { font-family: Arial, sans-serif; background: linear-gradient(135deg, #1a1a2e, #16213e); min-height: 100vh; margin: 0; padding: 20px; }
        .header { display: flex; justify-content: space-between; align-items: center; max-width: 700px; margin: 0 auto 20px; }
        .brand { color: #4CAF50; font-size: 1.4rem; font-weight: bold; }
        .header a { color: #ccc; text-decoration: none; border: 1px solid #ccc; padding: 6px 14px; border-radius: 5px; font-size: 13px; }
        .container { max-width: 700px; margin: 0 auto; background: white; padding: 35px; border-radius: 12px; box-shadow: 0 8px 25px rgba(0,0,0,0.3); }
        h1 { color: #2e7d32; text-align: center; margin-top: 0; font-size: 1.6rem; }
        .subtitle { text-align: center; color: #888; margin-bottom: 25px; font-size: 14px; }
        label { display: block; margin: 12px 0 4px; font-weight: bold; color: #444; font-size: 14px; }
        input[type=text], input[type=email], textarea, select { width: 100%; padding: 10px 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 14px; box-sizing: border-box; }
        input:focus, select:focus, textarea:focus { border-color: #4CAF50; outline: none; }
        textarea { height: 80px; resize: vertical; }
        .plan-cards { display: flex; gap: 15px; margin: 10px 0; }
        .plan-card { flex: 1; border: 2px solid #ddd; border-radius: 8px; padding: 14px; cursor: pointer; text-align: center; transition: all 0.2s; }
        .plan-card:hover { border-color: #4CAF50; background: #f1f8e9; }
        .plan-card input { display: none; }
        .plan-card h3 { margin: 0 0 5px; color: #333; font-size: 1rem; }
        .plan-card p { margin: 3px 0; font-size: 12px; color: #666; }
        .plan-card .price { font-size: 1.1rem; font-weight: bold; color: #2e7d32; }
        button[type=submit] { background: #2e7d32; color: white; width: 100%; padding: 13px; border: none; border-radius: 6px; font-size: 16px; cursor: pointer; margin-top: 20px; }
        button[type=submit]:hover { background: #1b5e20; }
        .msg-ok  { background: #e8f5e9; border-left: 4px solid #4CAF50; padding: 12px 16px; border-radius: 4px; color: #2e7d32; margin-bottom: 20px; font-size: 14px; }
        .msg-err { background: #fce4ec; border-left: 4px solid #e53935; padding: 12px 16px; border-radius: 4px; color: #c62828; margin-bottom: 20px; font-size: 14px; }
    </style>
</head>
<body>
    <div class="header">
        <span class="brand">DIGI NETWORK</span>
        <a href="1.customer.php">Login / Home</a>
    </div>
    <div class="container">
        <h1>Apply for New Cable Connection</h1>
        <p class="subtitle">Fill the form below. Our team will contact you within 2 working days.</p>

        <?php if ($success): ?>
            <div class="msg-ok"><?php echo htmlspecialchars($success); ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="msg-err"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="POST">
            <label>Full Name</label>
            <input type="text" name="full_name" placeholder="Your full name" required>

            <label>Email Address</label>
            <input type="email" name="email" placeholder="you@example.com" required>

            <label>Phone Number</label>
            <input type="text" name="phone" pattern="\d{10}" maxlength="10" placeholder="10-digit mobile number" required>

            <label>Full Address</label>
            <textarea name="address" placeholder="House/Flat no., Street, Landmark" required></textarea>

            <label>Area</label>
            <select name="area" required>
                <option value="">Select your area</option>
                <option value="ShivajiNagar">Shivaji Nagar</option>
                <option value="VijayNagar">Vijay Nagar</option>
                <option value="Saradwadi">Saradwadi</option>
                <option value="GaneshPeth">Ganesh Peth</option>
                <option value="Panchpakadi">Panchpakadi</option>
                <option value="Khopat">Khopat</option>
                <option value="Charai">Charai</option>
                <option value="Chandanwadi">Chandanwadi</option>
            </select>

            <label>Choose Plan</label>
            <div class="plan-cards">
                <label class="plan-card">
                    <input type="radio" name="subscription_type" value="Gold Pack" required>
                    <h3>Gold Pack</h3>
                    <p>SD Channels</p>
                    <p class="price">Rs. 450/month</p>
                    <p>15+ channels</p>
                </label>
                <label class="plan-card">
                    <input type="radio" name="subscription_type" value="Premium Pack" required>
                    <h3>Premium Pack</h3>
                    <p>HD Channels</p>
                    <p class="price">Rs. 650/month</p>
                    <p>15+ HD channels</p>
                </label>
            </div>

            <button type="submit" name="submit">Submit Connection Request</button>
        </form>
    </div>
</body>
</html>
