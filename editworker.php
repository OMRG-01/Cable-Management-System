<?php 
include ("connection.php"); 

$id = $_GET['id'];

$query = "SELECT * FROM form6 where id = '$id'";
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
    <link rel="stylesheet" type="text/css" href="css/style4.css">
</head>

<body>
        <div class="header">
            <div class="navbar">
                <ul>
                    <li><a href="worker.php">Return</a></li>
                </ul>
            </div>
        </div>
    <div class="container">
        <form action="#" method="POST">
            <div class="form">
                <div class="input_field">
                    <label>Name</label>
                    <input type="text" class="input" value="<?php echo $result['sname'];?>" name="sname">
                </div>
                <div class="input_field">
                    <label>Phone Number</label>
                    <input type="text" class="input" value="<?php echo $result['uname'];?>" name="uname">
                </div>
                <div class="input_field">
                    <label>Post</label>
                    <input type="text" class="input" value="<?php echo $result['dname'];?>" name="dname">
                </div>
                <div class="input_field">
                    <label>Salary</label>
                    <input type="number" class="input" value="<?php echo $result['hname'];?>" name="hname">
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" value="Register" name="register">Edit Worker</button>
                    <form action="#">
                    </form>
                </div>
        </form>
        </div>
        </div>
</body>
</html>
<?php 
    if(isset($_POST['register']))
    {
        $sname =$_POST['sname'];
        $uname =$_POST['uname'];
        $dname =$_POST['dname'];
        $hname =$_POST['hname'];

        $query = "UPDATE form6 set sname='$sname',uname='$uname',dname='$dname',hname='$hname' WHERE id ='$id'";
        $data = mysqli_query($conn,$query);                                                                                                                                                                                                                                                                                                                                                                                                                                                
        
        if($data)
        {
            echo "<script>alert('Record Updated')</script>";
            
            ?>
            <meta http-equiv="refresh" content="0; url='http://localhost/CMD/worker.php'" />

            <?php
        }
        else
        {
            echo "Failed to Update";
        }
    }
?>