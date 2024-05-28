<?php
// Include the db_conn.php file
include 'db_conn.php';

// Ensure the filename and file_column are valid
$filename = $_GET['filename'];
$file_column = $_GET['file_column'];

// Perform validation and sanitization as needed

// Fetch the file content from the database based on the file_column
$query = "SELECT $file_column FROM student WHERE $file_column" . "_filename = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "s", $filename);
mysqli_stmt_execute($stmt);
mysqli_stmt_bind_result($stmt, $file_content);
mysqli_stmt_fetch($stmt);
mysqli_stmt_close($stmt);

// Send the file to the user for download
header('Content-Type: application/octet-stream');
header('Content-Disposition: attachment; filename="' . $filename . '"');
echo $file_content;
?>
