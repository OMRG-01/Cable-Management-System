<?php
session_start();
if (!isset($_SESSION['admin_name'])) {
    header('Location: operator.php');
    exit;
}
include("connection.php");

if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $worker_id = (int)$_GET['id'];
    $stmt = mysqli_prepare($conn, "DELETE FROM form6 WHERE id=?");
    mysqli_stmt_bind_param($stmt, "i", $worker_id);
    mysqli_stmt_execute($stmt);
}
header('Location: worker.php');
exit;
?>
