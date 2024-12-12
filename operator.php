<?php 
session_start();
?>
<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="style4.css">

    
</head>

<body>
<div class="header">
            <div class="navbar">
                <ul>
                    <li><a href="1.customer.php">Home</a></li>
                </ul>
            </div>
        </div>
    <div class="container">
        <form method="POST" autocomplete="off">
            <div class="title">
                <h1>Admin Log In  !!! </h1>
            </div>
            <div class="form">
                <div class="input_field">
                    <label>Operator Id</label>
                    <input type="text" class="input" name="username" required>
                </div>
                <div class="input_field">
                    <label>Password</label>
                    <input type="password" class="input" name="password" required>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" value="Register" name="register"
                    formaction="#">Login</button>
                </div>
            </div>
        </form>
    </div>
    </body>

</html>


<?php

include ("connection.php");

if(isset($_POST['register']))
{
    $username = $_POST['username'];
    $password = $_POST['password'];

    $query = "SELECT * FROM form4 WHERE user = '$username' && pass ='$password' ";
    $data = mysqli_query($conn,$query);
    $total = mysqli_num_rows($data);

    //echo $total;

    if($total == 1)
        {   
            $_SESSION['user_name'] = $username;
            header('location:dashboard.html');
        }
        else
        {
            echo 'Login failed';
        }
    }

?>
