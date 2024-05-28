<?php session_start();
$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "my_db";
$conn = mysqli_connect($sname, $uname, $password, $db_name);

if (!$conn) {
    echo "Connection failed";
    exit();
}
$sname= $_SESSION['username'];
$query = "select * from `student`";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="mystyle.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
          form {
            margin: 0;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 5px;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .men{
            font-size:20px;
            color:white;
        } 

        </style>
</head>

<body>
    <div class="background-container">
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
 
<div class="heading-container">
            <h2 class="heading">Students Record</h2>
            <p class="sub-heading">Where Student Progress Meets Administrative Excellence!</p>
        </div>

        
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-info">
                    <tr>
            <th>Student Id</th>
            <th>Student Name</th>
            <th>Email</th>
            <th>Sec</th>
            <th>Semester</th>
            <th>Currently Working-On</th>
            
        </tr></thead>

        <?php
            while ($row = mysqli_fetch_assoc($result)) {
                
            ?>
             <tr>
                    <td><?php echo $row['id'] ?></td>
                    <td><?php echo $row['StudentName']; ?></td>
                <td><?php echo $row['mailId']; ?></td>
                <td><?php echo $row['sec']; ?></td>
                <td><?php echo $row['sem']; ?></td>
                <td style="background-color: <?php echo ($row['pid'] == null) ? 'rgb(255, 127, 127)' : 'lightgreen'; ?>;">
                    <?php
                    if ($row['pid'] == null)
                        echo "Not Working";
                    else{
                        $pid=$row['pid'];
                        $innerquery = "SELECT `ProjectTitle` FROM `record` WHERE `pid` = '$pid'";
                        $innerResult = mysqli_query($conn, $innerquery);
                        $name="";
                        if ($innerResult) {
                        $rowa = mysqli_fetch_assoc($innerResult);
                        $name = $rowa['ProjectTitle'];
                        echo $name;
                    }
                    else {
                        echo "Error in the query: " . mysqli_error($conn);
                    }
                }
            

                    ?>
                </td>
                <td style="border:none!important"><form method="POST" action="">
                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                    <input type="hidden" name="project_id" value="<?php echo $row['pid']; ?>">
                    <button class="btn btn-danger" type="submit" name="remove_project">Remove Project</button>
                </form></td>
<?php } ?>
        </table></div>
    </div>

    <?php

if (isset($_POST['remove_project'])) {
    $Stuid = $_POST['id'];
    $pid=$_POST['project_id'];
    // Perform the removal logic, for example:
    $delete_query = "UPDATE `student` SET `pid`=null,`progress`=null,`synopsis`=null,`srs`=null,`finalReport`=null,`srs_filename`=null,`synopsis_filename`=null,`finalReport_filename`=null WHERE `id`=$Stuid";
    $delete_result = mysqli_query($conn, $delete_query);
    $updateQuery="UPDATE `record` set `status`=1 where `pid`=$pid";
    $updateResult = mysqli_query($conn, $updateQuery);

    $delete_query2 = "DELETE from `request` where `pid`=$pid and `status`='approved'";
    $delete_result2 = mysqli_query($conn, $delete_query2);


    // if ($delete_result) {
    //     echo ".";
    // } else {
    //     echo "Error removing project: ";
    // }
    // if($updateResult){
    //     echo "Project status updated successfully.";
    // }
    // else{
    //     echo "Error removing project: " . mysqli_error($conn);
    // }
    
    // if($delete_query2){
    //     echo "Project deleted successfully.";
    // }
    // else{
    //     echo "Error removing project: " . mysqli_error($conn);
    // }
}
?>

</body>

</html>
