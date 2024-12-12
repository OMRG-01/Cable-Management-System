<?php 
include("connection.php");

session_start();
$userprofile = $_SESSION['user_name'];

$query = "SELECT * FROM form1 where hname = '$userprofile'";
$data = mysqli_query($conn, $query);

$result = mysqli_fetch_assoc($data);

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
                    <li><a href="CustomerPage.php">Return</a></li>
                </ul>
            </div>
        </div>
    <div class="container">
        <form action="#" method="POST">
            <div class="title">
                <h1>YOUR DETAILS </h1>
            </div>
            <div class="form">
                <div class="input_field">
                    <label>Email id</label>
                    <input type="text"class="input" value="<?php echo $result['cname'];?>" name="cname" required>
                </div>
                <div class="input_field">
                    <label>STB-Id</label>
                    <input type="text" class="input" value="<?php echo $result['sname'];?>" name="sname" required>
                </div>
                <div class="input_field">
                    <label>Phone Number</label>
                    <input type="text" class="input" value="<?php echo $result['pname'];?>" name="pname">
                </div>
                <div>
                    <div class="input_field">
                    <label>Area</label>
                    <select class="selectbox" name="selname" value="<?php echo $result['selname'];?>" required>
                        <option>Select</option>
                        <option value="Panchpakadi"
                        <?php
                                if($result['selname'] == 'Panchpakadi')
                                {
                                    echo "selected";
                                }
                            ?>
                        >Panchpakadi</option>
                        <option value="Khopat"
                        <?php
                                if($result['selname'] == 'Khopat')
                                {
                                    echo "selected";
                                }
                            ?>
                        >Khopat</option>
                        <option value="Charai"
                        <?php
                                if($result['selname'] == 'Charai')
                                {
                                    echo "selected";
                                }
                            ?>
                        >Charai</option>
                        <option value="Chandanwadi"
                        <?php
                                if($result['selname'] == 'Chandanwadi')
                                {
                                    echo "selected";
                                }
                            ?>
                        >Chandanwadi</option>
                    </select>
                    </div>
                <div class="input_field">
                    <label>Subscription</label>
                    <select class="selectbox" name="sename" value="<?php echo $result['sename'];?>" required>
                        <option>Select</option>
                        <option value="Premium Pack"
                            <?php
                                if($result['sename'] == 'Premium Pack')
                                {
                                    echo "selected";
                                }
                            ?>
                        >Premium Pack</option>
                        <option value="Gold Pack"
                            <?php
                                if($result['sename'] == 'Gold Pack')
                                {
                                    echo "selected";
                                }
                            ?>
                        >Gold Pack</option>Prices according to the selected Subscription
                        </select>
                </div>
                <div class="input_field">
                    <label>Set Username</label>
                    <input type="text" class="input" name="hname" value="<?php echo $result['hname'];?>" placeholder="eg.mayur@123" required>
                </div>
                <div class="input_field">
                    <label>Password</label>
                    <input type="password" class="input" name="rname" value="<?php echo $result['rname'];?>" placeholder="set Password" required>
                </div>
            </form>
                </div>
        </form>
        </div>
        </div>
</body>
</html>