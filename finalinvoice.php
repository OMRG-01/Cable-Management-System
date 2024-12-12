<?php
include("connection.php");

// Get the ID from the URL
$id = $_GET['id'];

// Fetch the details from `form8` for the respective ID
$query = "SELECT * FROM form8 WHERE id = '$id'";
$data = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($data);

if (!$result) {
    echo "<h2 align='center'>No record found for ID: $id</h2>";
    exit;
}
$payment_status = "Paid";
?>
<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f4f4f9;
        }
        .invoice-container {
            width: 70%;
            margin: auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #4CAF50;
            color: white;
        }
        td {
            background-color: #f9f9f9;
        }
        .paid-stamp {
            top: 20px;
            right: 70px;
            width: 150px;
            opacity: 0.7;
        }
        .print-btn {
            display: block;
            margin: auto;
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-align: center;
            text-decoration: none;
        }
        .print-btn:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <h2>Invoice</h2>
        <table>
            <tr>
                <th>Field</th>
                <th>Details</th>
            </tr>
            
            <tr>
                <td>User ID</td>
                <td><?php echo $result['user_id']; ?></td>
            </tr>
            <tr>
                <td>UPI Name</td>
                <td><?php echo $result['UPI_name']; ?></td>
            </tr>
            <tr>
                <td>Package Name</td>
                <td><?php echo $result['Package_name']; ?></td>
            </tr>
            <tr>
                <td>Month</td>
                <td><?php echo $result['month']; ?></td>
            </tr>
            <tr>
                <td>Mode Name</td>
                <td><?php echo $result['Mode_name']; ?></td>
            </tr>
            <tr>
                <td>Price</td>
                <td><?php echo $result['Price']; ?></td>
            </tr>
            <tr>
                <td>Transaction ID</td>
                <td><?php echo $result['Transaction_ID']; ?></td>
            </tr>
            <tr>
            <td>Payment Status</td>
            <td><?php echo $payment_status; ?></td>
            </tr>
        </table>
        <button class="print-btn" onclick="window.print()">Print Invoice</button>
        <img src="paid.png" class="paid-stamp" alt="PAID Stamp">
    </div>
</body>
</html>
