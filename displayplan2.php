<html>
<head>
    <title> Display Customers</title>
    <style>
        body {
            background: url('home2.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

         /* Header styles */
         .header {
            background-color: rgba(0, 0, 0, 0.6);
            padding: 10px 20px;
            display: flex;
            justify-content: flex-end;
            align-items: center;
        }

        .header a {
            font-size: 20px;
            color: white;
            text-decoration: none;
            border: 1px solid black;
            padding: 8px 15px;
            margin-left: 15px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .header a:hover {
            background-color: #007bff;
        }
        /* Table styling */
        table {
            width: 80%;
            margin: 50px auto;
            background-color: rgba(255, 255, 255, 0.8);
            border-collapse: collapse;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        th, td {
            padding: 15px;
            text-align: center;
            border: 1px solid #ddd;
        }

        th {
            background-color: #4CAF50;
            color: white;
        }

        td {
            background-color: #f2f2f2;
            color: black;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            font-size: 2rem;
            color: white;
        }

        .Edit {
            background: #4CAF50;
            color: white;
            border: 0;
            outline: none;
            border-radius: 5px;
            height: 30px;
            width: 80px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .Edit:hover {
            background: darkblue;
        }

        </style>
    </head>

<?php
include("connection.php");
error_reporting(0);

$query = "SELECT * FROM form5";
$data = mysqli_query($conn, $query);

$total = mysqli_num_rows($data);

//echo $total;
if($total != 0)
{
    ?>
    <div class="header">
            <div class="navbar">
                <a href="dashboard.html">Home</a>
                <a href="Editplans.php">Return</a>
            </div>
        </div>
        <h2 align ="center">Premium Pack Plans </h2>
    <table border="2" cellspacing="7" width="100%">
        <tr>
        <th width="5%">id</th>
        <th width="15%">Plan Name</th> 
        <th width="10%">Plan code</th>    
        <th width="5%">Price</th>
        <th width="10%">Quality</th>
        <th width="10%">Operation</th>
        </tr>
    <?php
    while($result = mysqli_fetch_assoc($data))
    {
        echo "<tr>
                <td>".$result['id']."</td>
                <td>".$result['mname']."</td>
                <td>".$result['aname']."</td>
                <td>".$result['yname']."</td>
                <td>".$result['uname']."</td>
                <td><a href='update_plan2.php?id=$result[id]'><input type='Submit' class='Edit' value='Edit'></a>
            </tr>";
    }
}    
else
{ 
    echo "No records found";
}
?>
</table>
