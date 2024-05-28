<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Time</title> 
        <link rel="stylesheet" href="mystyle.css" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <style>  
        .border {
            border: var(--bs-border-widthj) var(--bs-border-style) white !important;}
            #ProjectDesc::placeholder,#ProjectTitle::placeholder,#ProjectTech::placeholder{
            color:white;
            }
            .colblk{
            color:white;
            font-size: 20px;
            }
            .colbl{
            color:white;

            }
            ::placeholder {
                color: rgba(255, 255, 255, 0.5) !important; /* Light white color for the placeholder text */
            }
        </style>
</head> 

<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh; color:white;">
    <div style="box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); background-color: #333; padding: 20px; border-radius: 10px;">
        <form action="" method="POST" class="border shadow p-3 rounded">
        <h1 class="text-center p-3 mb-5 colbl" style="background-color: #555; padding: 10px; border-radius: 5px; font-family: 'Arial', sans-serif; font-size: 24px; text-transform: uppercase; letter-spacing: 2px;">Set Timer</h1>
            <label for="field">Select Field:</label>
            <select name="field" id="field">
                <option value="synopsis">Synopsis</option>
                <option value="srs">SRS</option>
                <option value="presentation1">Presentation 1</option>
                <option value="presentation2">Presentation 2</option>
                <option value="presentation3">Presentation 3</option>
                <option value="finalReport">Final Report</option>
            </select>
            <br>
            <label for="time">Set Time:</label>
            <input type="datetime-local" name="time" id="time">
            <br>
            <input type="submit" name="set_time" value="Set Time">
        </form>
    </div>
    <?php
session_start();

$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "my_db";
$conn = mysqli_connect($sname, $uname, $password, $db_name);
if (!$conn) {
    echo "Connection failed";
    exit();
}

if (isset($_POST['set_time'])) {
    $field = $_POST['field'];
    $time = $_POST['time'];

    // Format the time to match the timestamp format
    $formatted_time = date('Y-m-d H:i:s', strtotime($time));

    // Update time for the selected field in the timer table
    $sql_update = "UPDATE timer SET $field = '$formatted_time'";
    if (mysqli_query($conn, $sql_update)) {
        echo '<script>alert("Time set successfully");</script>';
    } else {
        echo '<script>alert("Error setting time");</script>';
    }
}
?>

</body>
</html>
