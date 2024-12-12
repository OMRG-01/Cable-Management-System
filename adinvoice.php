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

        .Update {
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

        .Update:hover {
            background: darkblue;
        }
        </style>
    </head>

<?php
include("connection.php");
error_reporting(0);

// Fetch data from `form8`
$query = "SELECT * FROM form8";
$data = mysqli_query($conn, $query);

$total = mysqli_num_rows($data);

if ($total != 0) {
    ?>
    <div class="header">
        <div class="navbar">
            <a href="dashboard.html">Return</a>
        </div>
    </div>
    <h2 align="center">Displaying all records</h2>
    
    <table border="2" cellspacing="10" width="100%">
        <tr>
            <th width="5%">Id</th>
            <th width="10%">User ID</th>
            <th width="15%">UPI Name</th>
            <th width="15%">Package Name</th>
            <th width="5%">Month</th>
            <th width="15%">Mode Name</th>
            <th width="10%">Price</th>
            <th width="15%">Transaction ID</th>
            <th width="10%">Payment Status</th>
            <th width="10%">Operations</th>
        </tr>
    <?php
    // Loop through and display records
    while ($result = mysqli_fetch_assoc($data)) {
        echo "<tr>
                <td>" . $result['id'] . "</td>
                <td>" . $result['user_id'] . "</td>
                <td>" . $result['UPI_name'] . "</td>
                <td>" . $result['Package_name'] . "</td>
                <td>" . $result['month'] . "</td>
                <td>" . $result['Mode_name'] . "</td>
                <td>" . $result['Price'] . "</td>
                <td>" . $result['Transaction_ID'] . "</td>
                <td>" . $result['payment_status'] . "</td>
                <td><a href='finalinvoice.php?id=" . $result['id'] . "'><input type='submit' value='Generate' class='Update'></a></td>
            </tr>";
    }
    ?>
    </table>
    <?php
} else {
    echo "<h2 align='center'>No records found</h2>";
}
?>

</table>

<script>
    function checkdelete()
    {
        return confirm('Are you sure want to delete this record ?');
    }
</script>