<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <!-- Link to Bootstrap CSS -->
   
    <link rel="stylesheet" type="text/css" href="css/style7.css">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Side Menu Bar</title>
</head>
<body>
    <div class="header">
    <nav class="navbar">
        <a href="aboutus.php">About Us</a>
        <a href="1.customer.php">Logout</a>
    </nav>
    </div>
 
    <div class="sidebar">
        <div class="logo">
            <img src="user.png" alt="Logo" width="40">
            <h4>    <?php
                    $userprofile = $_SESSION['user_name'];
                    echo  $userprofile;
                ?></h4>
        </div>
        <ul class="menu">
            <li><a href="upcustomer.php">Update My Details</a></li>
            <li><a href="editplanC.php">Subscription</a></li>
            <li><a href="pay.php">Payment</a></li>
        </ul>
    </div>

    <div class="container" style="margin-top: 5px;"> <!-- Adjusted for navbar height -->
        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h2>View Your Details</h2>
                        <h3><a href="customerdetails.php">View</a></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Link to Bootstrap JS and dependencies -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zyf0L9g9z5rfb9a0p6u4LgR8g7gkL5mU4v5+BdSt" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8Fq7X9b3fUjFf5k5pttHtD5aXl+YqC0cYoHj1J3WwDdOlo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-pzjw8f+ua7Kw1TIq0v8Fq7X9b3fUjFf5k5pttHtD5aXl+YqC0cYoHj1J3WwDdOlo" crossorigin="anonymous"></script>
</body>
</html>
