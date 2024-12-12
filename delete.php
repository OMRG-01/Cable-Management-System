<?php 
include("connection.php");

$Id = $_GET['id'];
$query ="DELETE FROM form1 WHERE id='$Id'";
$data =mysqli_query($conn,$query);

if($data)
{
    //echo "Record Deleted";
    ?>
        <meta http-equiv="refresh" content="1; url='http://localhost/CMD/updatecustomer.php'" />
    <?php
}
else
{
    echo "Failed to Delete";
}

?>