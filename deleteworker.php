<?php
// Include the database connection
include("connection.php");

// Check if the 'id' parameter is passed in the URL
if (isset($_GET['id'])) {
    // Get the worker id from the URL
    $worker_id = $_GET['id'];

    // Create the DELETE query
    $query = "DELETE FROM form6 WHERE id = '$worker_id'";

    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Redirect to the worker listing page after successful deletion
        header("Location: worker.php"); // Adjust the redirect location as needed
        exit();
    } else {
        // If the deletion failed, show an error message
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    // If no 'id' is passed, redirect to the worker listing page
    header("Location: worker.php");
    exit();
}
?>
