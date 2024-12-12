<?php 
include ("connection.php"); 
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
                    <li><a href="PP.php">Return</a></li>
                </ul>
            </div>
        </div>
    <div class="container">
        <form action="#" method="POST">
            <div class="form">
                <div class="input_field">
                    <label>Plan Name</label>
                    <input type="text" class="input" name="plname">
                </div>
                <div class="input_field">
                    <label>Plan code</label>
                    <input type="text" class="input" name="pcname">
                </div>
                <div class="input_field">
                    <label>Price</label>
                    <input type="number" class="input" name="prname">
                </div>  
                <div class="input_field">
                    <label>Qualtiy</label>
                    <select class="selectbox" name="qname">
                        <option>Select</option>
                        <option>HD Pack</option>
                        <option>SD Pack</option>
                        </select>
                </div>
                <div class="input_field">
                    <button type="submit" class="btn" value="Register" name="register">Add Plan</button>
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
        $plname =$_POST['plname'];
        $pcname =$_POST['pcname'];
        $prname =$_POST['prname'];
        $qname =$_POST['qname'];

        if($plname !="" && $pcname !="" && $prname !="" && $qname !="" )

        $query = "INSERT INTO form2 (plname,pcname,prname,qname) VALUES('$plname','$pcname','$prname','$qname')";                                                                                                                                                                                                                                                                                                                                                                                                                                                  
        $data = mysqli_query($conn,$query);

        if($data)
        {
            echo "<script>alert('Plan added');</script>";
        }
        else
        {
            echo "Failed";
        }
    }
    
?>