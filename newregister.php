<?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>New Registration</title>
    <link rel="stylesheet" type="text/css" href="css/style9.css">
</head>
<body>
    <div class="container">
        <form method="POST" autocomplete="off">
            <div class="title">
                <h1>NEW REGISTRATION</h1>
            </div>
            <div class="form">
                <!-- Email Input -->
                <div class="input_field">
                    <label>Email ID</label>
                    <input type="text" class="input" name="cname" 
                        pattern="[a-zA-Z0-9._%+-]+@gmail\.com" 
                        title="Please enter a valid Gmail address" 
                        required>
                </div>
                <!-- STB ID Input -->
                <div class="input_field">
                    <label>STB-ID</label>
                    <input type="text" class="input" name="sname" 
                        pattern="\d{6}" 
                        placeholder="e.g., 123456" 
                        required>
                </div>
                <!-- Phone Number Input -->
                <div class="input_field">
                    <label>Phone Number</label>
                    <input type="text" class="input" name="pname" 
                       
                        maxlength="12" 
                        placeholder="e.g., 123-456-7890" 
                        required>
                </div>
                <!-- Area Selection -->
                <div class="input_field">
                    <label>Area</label>
                    <select class="selectbox" name="selname" required>
                        <option value="">Select</option>
                        <option value="ShivajiNagar">Shivaji Nagar</option>
                        <option value="VijayNagar">Vijay Nagar</option>
                        <option value="Saradwadi">Saradwadi</option>
                        <option value="GaneshPeth">Ganesh Peth</option>
                    </select>
                </div>
                <!-- Subscription Selection -->
                <div class="input_field">
                    <label>Subscription</label>
                    <select class="selectbox" name="sename" required>
                        <option value="">Select</option>
                        <option value="Premium Pack">Premium Pack</option>
                        <option value="Gold Pack">Gold Pack</option>
                    </select>
                </div>
                <!-- Username Input -->
                <div class="input_field">
                    <label>Set Username</label>
                    <input type="text" class="input" name="hname" 
                        placeholder="e.g., mayur@123" 
                        required>
                </div>
                <!-- Password Input -->
                <div class="input_field">
                    <label>Password</label>
                    <input type="password" class="input" name="rname" 
                        placeholder="Set Password" 
                        pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}" 
                        title="Password must contain at least 8 characters, including uppercase, lowercase, number, and special character" 
                        required>
                </div>
                <!-- Register Button -->
                <div class="input_field">
                    <button type="submit" class="btn" name="register">Register</button>
                </div>
                <!-- Back to Login -->
                <div class="flex">
                    <form action="1.customer.php">
                        <button class="button">Back to Login</button>
                    </form>
                </div>
            </div>
        </form>
    </div>
    </body>
    </html>
    <?php
// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include database connection
include("connection.php");

// Check for form submission
if (isset($_POST['register'])) {
    // Retrieve form data
    $cname = $_POST['cname'];
    $sname = $_POST['sname'];
    $pname = $_POST['pname'];
    $selname = $_POST['selname'];
    $sename = $_POST['sename'];
    $hname = $_POST['hname'];
    $rname = $_POST['rname'];

    // Check if the form fields are empty
    if (!empty($cname) && !empty($sname) && !empty($pname) && 
        !empty($selname) && !empty($sename) && 
        !empty($hname) && !empty($rname)) {

        
            $query = "INSERT INTO form1 (cname,sname,pname,selname,sename,hname,rname) VALUES('$cname','$sname','$pname','$selname','$sename','$hname','$rname')";                                                                                                                                                                                                                                                                                                                                                                                                                                                  
            $data = mysqli_query($conn,$query);
    
            if($data)
            {
                echo "Registered Sucessfully";
            }
            else
            {
                echo "Failed";
            }
}
}
?>
