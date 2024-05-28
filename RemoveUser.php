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

if (isset($_POST['delete'])) {
    $deleted_faculty_id = $_POST['faculty'];
    $transfer_to_faculty_id = $_POST['transfer_to_faculty'];

    // Update related tables to transfer work
    $tables = ['record', 'request', 'suggestion'];
    foreach ($tables as $table) {
        $sql_update = "UPDATE $table SET fid = '$transfer_to_faculty_id' WHERE fid = '$deleted_faculty_id'";
        mysqli_query($conn, $sql_update);
    }

    // Delete faculty from users table
    $sql_delete = "DELETE FROM users WHERE id = '$deleted_faculty_id'";
    if (mysqli_query($conn, $sql_delete)) {
        echo '<script>alert("Faculty deleted successfully");</script>';
    } else {
        echo '<script>alert("Error deleting faculty");</script>';
    }
}
?>

<html>
<head>
    <title>Admin</title>
    
<link rel="stylesheet" href="mystyle.css" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
   
<input type="checkbox" id="menu-toggle" checked>
<div class="menu dflex">
  <div id="logoCSS3" class="text-center">
    <i class="fa fa-css3"></i>
  </div>
  <div class="elements-container dflex">
  <a class="element" href="DashboardA.php">
                <i class="fa fa-dashboard"></i> Student Record
            </a>
            <a class="element" href="AddUser.php">
                <i class="fa fa-user-plus"></i> Add a New User
            </a>
            <a class="element" href="RemoveUser.php">
                <i class="fa fa-user-times"></i> Remove a User
            </a>
            <a class="element" href="AdminReport.php">
                <i class="fa fa-leaf"></i> Generate Report
            </a>
            <a class="element" href="logout.php">
                <i class="fa fa-sign-out"></i> Logout
            </a>
            <a class="element" href="changepswd.php">
                <i class="fa fa-cogs"></i> Change Password
            </a>
        </div>
  <div class="menu-container-btn">
    <div class="menu-toggle-btn">
      <label class="menu-btn text-center" for="menu-toggle">
          <i class="fa fa-close"></i>
          <i class="fa fa-bars"></i>
        </label>
    </div>
  </div>
</div>
<div id="myModal" class="modal1">
  <div class="modal-content">
    <span class="close" id="closeModal">&times;</span>
    <p id="popupMessage">Sorry! The Project is Unavailable</p>
  </div>
</div>
<script>
    // Function to close the modal
    function closeModal() {
        document.getElementById("myModal").style.display = "none";
    }
    document.getElementById("closeModal").addEventListener("click", closeModal);
  window.addEventListener("click", function(event) {
        if (event.target == document.getElementById("myModal")) {
            closeModal();
        }
    });
</script>
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh; color:white;">
    <div style="box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); background-color: #333; padding: 20px; border-radius: 10px;">
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Faculty</title>
    <!-- Include your CSS and Bootstrap links here -->
</head>
<body>
<div class="container d-flex justify-content-center align-items-center" style="min-height:100vh; color:white;">
    <div style="box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); background-color: #333; padding: 20px; border-radius: 10px;">
        <form action="" method="POST" class="border shadow p-3 rounded">
        <h1 class="text-center p-3 mb-5 colbl" style="background-color: #555; padding: 10px; border-radius: 5px; font-family: 'Arial', sans-serif; font-size: 24px; text-transform: uppercase; letter-spacing: 2px;">Delete a User</h1>
            <label for="faculty">Select Faculty:</label>
            <select name="faculty" id="faculty">
                <?php
                // Assuming $conn is your database connection
                $sql = "SELECT * FROM users WHERE role = 'faculty'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                } else {
                    echo "<option value=''>No faculty available</option>";
                }
                ?>
            </select>
            <label for="faculty">Select Faculty to transfer work:</label>
            <select name="transfer_to_faculty" id="transfer_to_faculty">
                <?php
                // Assuming $conn is your database connection
                $sql = "SELECT * FROM users WHERE role = 'faculty'";
                $result = mysqli_query($conn, $sql);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='".$row['id']."'>".$row['name']."</option>";
                    }
                } else {
                    echo "<option value=''>No faculty available</option>";
                }
                ?>
            </select>
            <input type="submit" name="delete" value="Delete">
        </form>
    </div>
</body>
</html>
    </div>
</div>


</body>
</html>
