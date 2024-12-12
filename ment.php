<?php
include("connection.php");

session_start();
$userprofile = $_SESSION['user_name'];

// Fetch user ID from form1 using session-based user profile
$query = "SELECT * FROM form1 WHERE hname = '$userprofile'";
$data = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($data);
$user_id = $result['id'];  // Capture the user_id from form1

// Get the form data
$upi_name = $_POST['Upi_name'];
$package_name = $_POST['Package_name'];
$month = $_POST['month'];
$mode_name = $_POST['mode_name'];
$transaction_id = $_POST['transaction_id'];
$price = ($package_name == 'Premium Pack') ? 650 : 450;  // Example of setting price based on package

// Insert data into form8
$query = "INSERT INTO form8 (user_id, UPI_name, Package_name, month, Mode_name, Price, Transaction_ID, payment_status) 
          VALUES ('$user_id', '$upi_name', '$package_name', '$month', '$mode_name', '$price', '$transaction_id', 'Pending')";

if (mysqli_query($conn, $query)) {
    echo "Payment data saved successfully!";
} else {
    echo "Error: " . mysqli_error($conn);
}

$userprofile = $_SESSION['user_name'];

// Fetch user ID from form1 using session-based user profile
$query = "SELECT * FROM form1 WHERE hname = '$userprofile'";
$data = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($data);
$user_id = $result['id'];  // Capture the user_id from form1

// Fetch the payment record from form8
$query = "SELECT * FROM form8 WHERE user_id = '$user_id' ORDER BY id DESC LIMIT 1";  // Get the latest payment record
$data = mysqli_query($conn, $query);
$payment_info = mysqli_fetch_assoc($data);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        /* Optional styling for the button */
        .print-btn {
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
        }

        .print-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Invoice</h1>
    <p><strong>UPI Name:</strong> <?php echo $payment_info['UPI_name']; ?></p>
    <p><strong>Package Name:</strong> <?php echo $payment_info['Package_name']; ?></p>
    <p><strong>Month:</strong> <?php echo $payment_info['month']; ?></p>
    <p><strong>Mode:</strong> <?php echo $payment_info['Mode_name']; ?></p>
    <p><strong>Price:</strong> Rps <?php echo $payment_info['Price']; ?>/-</p>
    <p><strong>Transaction ID:</strong> <?php echo $payment_info['Transaction_ID']; ?></p>
    <p><strong>Status:</strong> <?php echo $payment_info['payment_status']; ?></p>
    <!-- Print Button -->
    <button class="print-btn" onclick="window.print()">Print Invoice</button>

    <script>
        // Optional: If you want to customize the print dialog, you can use the window.print method here.
    </script>
</body>
</html>
