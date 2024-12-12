<?php 
include("connection.php");

session_start();
$userprofile = $_SESSION['user_name'];

// Fetch the user ID from form1 based on the username
$query = "SELECT * FROM form1 WHERE hname = '$userprofile'";
$data = mysqli_query($conn, $query);
$result = mysqli_fetch_assoc($data);

// Get user ID from form1
$user_id = $result['id'];

// Handling form submission for payment details
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Extract payment data from the form
    $upi_name = $_POST['Upi_name'];
    $package_name = $_POST['Package_name'];
    $month = $_POST['month'];
    $mode_name = $_POST['mode_name'];

    // Price calculation based on the package selected
    $price = ($package_name == 'Premium Pack') ? 650 : 450;

   
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Management System</title>
    <style>
        body {
            background-image: url('remote.jpg');
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-size: cover;
            background-position: center;
        }

        .container2 {
            background-color: white;
            border: 2px solid black;
            width: 600px;
            margin-right: auto;
            margin-left: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1, h2 {
            text-align: center;
            color: #4CAF50;
        }

        label {
            font-weight: bold;
            padding: 5px;
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
            color: #333;
        }

        input, select {
            width: 90%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 20px;
            display: inline-block;
            width: 100%;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .header .navbar {
            font-size: 20px;
            width: 100%;
            display: flex;
            justify-content: flex-end;
            margin-right: 20px;
        }

        .header .navbar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .header .navbar li {
            display: inline-block;
            margin-left: 20px;
        }

        .header .navbar a {
            font-size: 18px;
            color: black;
            text-decoration: none;
            padding: 10px;
            border: 1px solid black;
            border-radius: 5px;
            background-color: #f1f1f1;
            transition: background-color 0.3s;
        }

        .header .navbar a:hover {
            background-color: #ddd;
        }

        h4 {
            font-size: 14px;
            color: #666;
            line-height: 1.6;
            margin-top: 20px;
        }

        input:focus, select:focus {
            outline: none;
            border-color: #4CAF50;
        }

        .container2 form {
            display: flex;
            flex-direction: column;
        }

        .container2 form h1 {
            color: #4CAF50;
        }
    </style>
</head>
<body>        
    <div class="header">
        <div class="navbar">
            <ul>
                <li><a href="CustomerPage.php">Return</a></li>
            </ul>
        </div>
    </div>

    <div class="container2">
        <h1>Pay on the Following UPI-No.</h1>
        <form action="ment.php" method="post">
            <label for="Upi_name">UPI Id:</label>
            <input type="text" id="Upi_name" value="omgawali-1@okaxis" name="Upi_name" required>

            <label for="Package_name">Package Name:</label>
            <input type="text" id="Package_name" value="<?php echo $result['sename'];?>" name="Package_name" required>        
            
            <label for="month">Select Month:</label>
            <select id="month" name="month">
                <option value="01">January</option>
                <option value="02">February</option>
                <option value="03">March</option>
                <option value="04">April</option>
                <option value="05">May</option>
                <option value="06">June</option>
                <option value="07">July</option>
                <option value="08">August</option>
                <option value="09">September</option>
                <option value="10">October</option>
                <option value="11">November</option>
                <option value="12">December</option>
            </select>

            <label for="Mode_name">Mode:</label>
            <select name="mode_name" id="mode_name">
                <option value="Monthly">Monthly only</option>
            </select>
            <label for="transaction_id">Transaction ID:</label>
            <input type="text" name="transaction_id" required>
            <label>Price:
                <?php
                    if($result['sename'] == 'Premium Pack')
                    {
                        echo "Rps 650/-";
                    }
                ?>
                <?php
                    if($result['sename'] == 'Gold Pack')
                    {
                        echo "Rps 450/-";
                    }
                ?>
            </label> 

            <h4>Kindly Gmail us...<br>
                1) Your payment details along with the transaction Id
                on "Saylicable99@gmail.com" to confirm your validity.</br>
                2) Also Please mention the month you are willing to pay.<br>
                3) Payment must be done 2 days before the end of the package validity.<br>
                4) For payment-related issues, contact us at 9987452112.
            </h4>

            <form action="ment.php" method="POST">
    <!-- Your form fields here -->
    <button type="submit">Submit Payment</button>
</form>

        </form>

        <h1>THANK YOU</h1>
    </div>

    <script>
        // JavaScript for form validation
        document.querySelector('form').addEventListener('submit', function(event) {
            let upiId = document.getElementById('Upi_name').value;
            let packageName = document.getElementById('Package_name').value;
            let month = document.getElementById('month').value;

            // Simple validation for UPI ID, package selection, and month
            if (!upiId || !packageName || !month) {
                alert("Please fill all fields before submitting.");
                event.preventDefault();
            } else {
                alert("Payment details submitted successfully!");
            }
        });
    </script>
</body>
</html>
