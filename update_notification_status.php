<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['id'])) {
    // Redirect to the login page if not logged in
    header("Location: login.php");
    exit();
}

// Include database connection
include_once("db_conn.php");

if(isset($_POST['message'])) {
    $message = $_POST['message'];
    $user_id = $_SESSION['username'];

    // Update notification status in the database
    $myq = "UPDATE notifications SET `status`=1 WHERE `message` = '$message' AND sid = '$user_id'";
    $result = $conn->query($myq);

    if ($result) {
        // If update is successful, return success message
        echo "Notification status updated successfully";
    } else {
        // If update fails, return error message
        echo "Failed to update notification status";
    }
} else {
    // If message parameter is not set, return error message
    echo "Message parameter is not set";
}

// Close the database connection
$conn->close();
?>
