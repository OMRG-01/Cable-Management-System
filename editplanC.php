<?php 
include("connection.php");

session_start();
$userprofile = $_SESSION['user_name'];

$query = "SELECT * FROM form1 WHERE hname = '$userprofile'";
$data = mysqli_query($conn, $query);

$result = mysqli_fetch_assoc($data);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Menu Bar</title>
    <link rel="stylesheet" href="css/style6.css">
</head>
<body>
<div class="header">
    <nav class="navbar">
        <a href="CustomerPage.php">Return</a>
        <a href="1.customer.php">Logout</a>
    </nav>
</div>

   
<div class="selected-section">
    <h3>You have selected "<?php echo $result['sename']; ?>"</h3>
    <h3>See Which Channel You Get In Packages</h3>
</div>

<div class="container">
        <div class="content">
            <!-- Cards Section -->
            <div class="cards">
                <!-- Gold Pack Card -->
                <div class="card">
                    <div class="box">
                        <h2>Gold Pack</h2>
                        <h3><a href="displayplan1.php">View</a></h3>
                    </div>
                    <div class="icon-case">
                        <!-- Optionally add an icon here -->
                    </div>
                </div>

                <!-- Premium Pack Card -->
                <div class="card">
                    <div class="box">
                        <h2>Premium Pack</h2>
                        <h3><a href="displayplan3.php">View</a></h3>
                    </div>
                    <div class="icon-case">
                        <!-- Optionally add an icon here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
