<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mechanics</title>
    <style>
         body {
            background: url('../image/home2.jpg') no-repeat center center fixed;
            background-size: cover;
            color: white;
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        
        h2 {
            text-align: center;
            margin-top: 20px;
            font-size: 2rem;
        }

        table {
            margin: 20px auto;
            text-align: center;
            background: yellow;
            width: 80%;
            border-collapse: collapse;
        }

        th, td {
            padding: 15px;
            border: 1px solid black;
        }

        th {
            background-color: #2c3e50;
            color: white;
        }

        td {
            background-color: #f2f2f2;
            color: black;
        }

        .Update, .Delete {
            background: yellow;
            color: blaack;
            border: 0;
            outline: none;
            border-radius: 5px;
            height: 30px;
            width: 80px;
            font-weight: bold;
            cursor: pointer;
        }

        .Delete {
            background: red;
        }

        .button {
            display: flex;
            background-color: #f05462;
            color: white;
            font-size: 20px;
            position: absolute;
            top: 5px;
            right: 100px;
            text-decoration: none;
            border-color: white;
            padding: 10px 20px;
            border-radius: 5px;
        }

        /* Header styles */
        .header .navbar {
            font-size: 20px;
            width: 100%;
            display: flex;
        }

        .header .navbar ul {
            color: white;
            width: 100%;
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: flex-end;
            margin-right: 10px;
        }

        .header .navbar li {
            text-decoration: none;
            margin-top: 10px;
            padding: 0px 10px;
            margin-right: 20px;
        }

        .header .navbar a {
            font-size: 25px;
            color: white;
            text-decoration: none;
            border: 1px solid black;
            padding: 10px;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }

        .header .navbar a:hover {
            background-color: #007bff;
        }
    </style>
</head>
<body>

<?php
include("connection.php");
error_reporting(0);

$query = "SELECT * FROM form6";
$data = mysqli_query($conn, $query);

$total = mysqli_num_rows($data);

if($total != 0) {
    ?>
    <h2>Workers</h2>
    <div class="header">
        <div class="navbar">
            <ul>
                <li><a href="dashboard.html">Return</a></li>
            </ul>
        </div>
    </div>

    <table>
        <tr>
            <th width="5%">Id</th> 
            <th width="10%">Name</th>    
            <th width="10%">Phone Number</th>
            <th width="10%">Post</th>
            <th width="10%">Salary</th>
            <th width="15%">Operations</th>
        </tr>

        <?php
        while($result = mysqli_fetch_assoc($data)) {
            echo "<tr>
                    <td>".$result['id']."</td>
                    <td>".$result['sname']."</td>
                    <td>".$result['uname']."</td>
                    <td>".$result['dname']."</td>
                    <td>".$result['hname']."</td>
                    <td>
                        <a href='editworker.php?id=$result[id]'>
                            <button class='Update'>Edit</button>
                        </a>
                        <a href='deleteworker.php?id=$result[id]' onclick='return checkdelete()'>
                            <button class='Delete'>Delete</button>
                        </a>
                    </td>
                </tr>";
        }
    } else { 
        echo "<p align='center' class='no-records'>No records found</p>";
    }
    ?>
    </table>
    
    <script>
        function checkdelete() {
            return confirm('Are you sure you want to delete this record?');
        }
    </script>
</body>
</html>
