<?php 
include ("connection.php"); 

$id = $_GET['id'];

$query = "SELECT * FROM form5 WHERE id = '$id'";
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
    <title>Update Record</title>
</head>

<body>
    <div class="container">
        <form action="#" method="POST">
            <div class="form">
                <div class="input_field">
                    <label>Movie Name</label>
                    <input type="text" value="<?php echo $result['mname'];?>" class="input" name="mname" required>
                </div>
                <div class="input_field">
                    <label>Actor Name</label>
                    <input type="text" value="<?php echo $result['aname'];?>" class="input" name="aname" required>
                </div>
                <div class="input_field">
                    <label>Price</label>
                    <input type="text" value="<?php echo $result['yname'];?>" class="input" name="yname" required>
                </div>  
                <div class="input_field">
                    <label>Uploader Name</label>
                    <input type="text" value="<?php echo $result['uname'];?>" class="input" name="uname" required>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" value="Update" name="update">Update Record</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>

<?php 
    if(isset($_POST['update']))
    {
        $mname = $_POST['mname'];
        $aname = $_POST['aname'];
        $yname = $_POST['yname'];
        $uname = $_POST['uname'];

        $query = "UPDATE form5 SET mname='$mname', aname='$aname', yname='$yname', uname='$uname' WHERE id ='$id'";
        $data = mysqli_query($conn, $query);                                                                                                                                                                                                                                                                                                                                                                                                                                                 
        
        if($data)
        {
            echo "<script>alert('Record Updated')</script>";
            ?>
            <meta http-equiv="refresh" content="0; url='http://localhost/CMD/displayplan2.php'" />
            <?php
        }
        else
        {
            echo "Failed to Update";
        }
    }
?>
