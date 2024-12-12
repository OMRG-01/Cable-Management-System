<!DOCTYPE html>
<html>
<head>
    <title>Display Customers</title>
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

        .Update {
            background: blue;
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

        .Update:hover {
            background: darkblue;
        }

        .Delete {
            background: red;
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

        .Delete:hover {
            background: darkred;
        }
    </style>
</head>
<body>
<?php
include("connection.php");
error_reporting(0);

$query = "SELECT * FROM form1";
$data = mysqli_query($conn, $query);

$total = mysqli_num_rows($data);

if ($total != 0) {
    ?>
    <div class="header">
        <div class="navbar">
            <ul>
                <li><a href="dashboard.html">Return</a></li>
            </ul>
        </div>
    </div>
    <h2>Displaying all records</h2>
    <table>
        <tr>
            <th>Id</th>
            <th>Email id</th>
            <th>STB-Id id</th>
            <th>Phone Number</th>
            <th>Area</th>
            <th>Subscription</th>
            <th>Username</th>
            <th>Password</th>
            <th>Operations</th>
        </tr>
    <?php
    while ($result = mysqli_fetch_assoc($data)) {
        echo "<tr>
                <td>{$result['id']}</td>
                <td>{$result['cname']}</td>
                <td>{$result['sname']}</td>
                <td>{$result['pname']}</td>
                <td>{$result['selname']}</td>
                <td>{$result['sename']}</td>
                <td>{$result['hname']}</td>
                <td>{$result['rname']}</td>
                <td>
                    <a href='update_design.php?id={$result['id']}'><input type='submit' value='Update' class='Update'></a>
                    <a href='delete.php?id={$result['id']}'><input type='submit' value='Delete' class='Delete' onclick='return checkdelete()'></a>
                </td>
            </tr>";
    }
} else {
    echo "<h2>No records found</h2>";
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
