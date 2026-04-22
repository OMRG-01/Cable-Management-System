<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: updatecustomer.php');
    exit;
}
$Id = (int)$_GET['id'];

$stmt = mysqli_prepare($conn, "DELETE FROM form1 WHERE id = ?");
mysqli_stmt_bind_param($stmt, "i", $Id);
if (mysqli_stmt_execute($stmt)) {
    header('Location: updatecustomer.php');
} else {
    echo "Failed to delete: " . mysqli_error($conn);
}
exit;
?>
