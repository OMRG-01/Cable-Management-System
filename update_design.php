<?php 
include ("connection.php"); 
session_start();

$Id = $_GET['id'];

$userprofile = $_SESSION['user_name'];

$query = "SELECT * FROM form1 where id = '$Id'";
$data = mysqli_query($conn, $query);

$total = mysqli_num_rows($data);
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
                    <li><a href="updatecustomer.php">Return</a></li>
                </ul>
            </div>
        </div>
    <div class="container">
        <form action="#" method="POST">
            <div class="title">
                <h1>UPDATE DETAILS </h1>
            </div>
            <div class="form">
                <div class="input_field">
                    <label>Email Id</label>
                    <input type="text" value="<?php echo $result['cname'];?>" class="input" name="cname" pattern="[a-zA-Z0-9._%+-]+@gmail\.com"
                    title="Please enter a valid Gmail address" required>
                </div>
                <div class="input_field">
                    <label>STB-Id</label>
                    <input type="text" value="<?php echo $result['sname'];?>" class="input" name="sname" pattern="\d{6}" required>
                </div>
                <div class="input_field">
                    <label>Phone Number</label>
                    <input type="number" value="<?php echo $result['pname'];?>" class="input" name="pname" pattern="[0-9]{3}-[0-9]{3}-[0-9]{4}" maxlength="12" placeholder="xxx-xxx-xxxx">
                </div>
                <div>
                    <div class="input_field">
                    <label>Area</label>
                    <select class="selectbox" value="<?php echo $result['selname'];?>" name="selname" required>
                        <option >Select</option>
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
                    <select class="selectbox" value="<?php echo $result['sename'];?>" name="sename" required>
                        <option>Select</option>
                        <option value="Premium Pack"
                            <?php
                                if($result['sename'] == 'Premium Pack')
                                {
                                    echo "selected";
                                }
                            ?>
                        >Premium Pack</option>
                        <option  value="Gold Pack"
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
                    <input type="text" class="input" value="<?php echo $result['hname'];?>" name="hname" placeholder="eg.mayur@123" required>
                </div>
                <div class="input_field">
                    <label>Password</label>
                    <input type="password" class="input" value="<?php echo $result['cname'];?>" name="rname" placeholder="set Password"
                    pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}"
                    title="Password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one number, and one special character" required>
                </div> 
                <div class="input_field">
                    <button type="submit" class="btn" value="Update" name="register">Update Details</button>
                </div>
        </form>
        </div>
        </div>
</body>
</html>

<?php 
    if(isset($_POST['register']))
    {
        $cname =$_POST['cname'];
        $sname =$_POST['sname'];
        $pname =$_POST['pname'];
        $selname =$_POST['selname'];
        $kname =$_POST['kname'];
        $sename =$_POST['sename'];
        $hname =$_POST['hname'];
        $rname =$_POST['rname'];                                                                                                                                                                                                                                                                                                                                                                                                                           
        
        $query= "UPDATE form1 set cname='$cname',sname='$sname',pname='$pname',selname='$selname',kname='$kname',sename='$sename',hname='$hname',rname='$rname' WHERE id ='$Id'";         
        $data = mysqli_query($conn,$query);
        
        if($data)
        {
            echo "<script>alert('Record Updated')</script>";
            
            ?>
            <meta http-equiv="refresh" content="1; url='http://localhost/CMD/updatecustomer.php'" />

            <?php
        }
        else
        {
            echo "Failed to Update";
        }
    }
    
?>
