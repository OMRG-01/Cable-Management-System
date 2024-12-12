<html>
<head>
    <title>Display Customers</title>
    <style>
        /* Set the background image */
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
            color:black;
        }

        h2 {
            text-align: center;
            margin-top: 20px;
            font-size: 2rem;
            color: white;
        }

        /* Styling for no records found message */
        .no-records {
            text-align: center;
            color: white;
            font-size: 1.5rem;
            margin-top: 20px;
        }

    </style>
</head>

<?php
include("connection.php");
error_reporting(0);

$query = "SELECT * FROM form5";
$data = mysqli_query($conn, $query);

$total = mysqli_num_rows($data);

if($total != 0) {
    ?>
    <div class="header">
        <div class="navbar">
            <ul>
                <li><a href="editplanC.php">Return</a></li>
            </ul>
        </div>
    </div>

    <h2>Plans (All HD Channels)</h2>

    <table>
        <tr>
            <th width="5%">id</th>
            <th width="15%">Plan Name</th>
            <th width="10%">Plan code</th>
            <th width="5%">Price</th>
            <th width="10%">Quality</th>
        </tr>
        <?php
        while($result = mysqli_fetch_assoc($data)) {
            echo "<tr>
                    <td>".$result['id']."</td>
                    <td>".$result['mname']."</td>
                    <td>".$result['aname']."</td>
                    <td>".$result['yname']."</td>
                    <td>".$result['uname']."</td>
                </tr>";
        }
        ?>
    </table>

<?php
} else {
    echo "<div class='no-records'>No records found</div>";
}
?>

</body>
</html>
