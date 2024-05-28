<?php
session_start();
ob_start();
ob_end_flush();
$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "my_db";
$fac = $_SESSION['id']; // Assuming 'username' holds the faculty username
$conn = mysqli_connect($sname, $uname, $password, $db_name);
if (!$conn) {
    echo "Connection failed";
    exit();
}
$query = "SELECT * FROM suggestion WHERE fid='$fac' AND status != 'approved'"; // Exclude suggestions with status 'approved'
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>

<head>
    <title>Project Ideas</title>

    <link rel="stylesheet" href="mystyle.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        form {
            margin: 0;
        }
    </style>
</head>

<body>

    <!-- Code to insert vertical sidebar -->

    <input type="checkbox" id="menu-toggle" checked>
    <div class="menu dflex">
        <div id="logoCSS3" class="text-center">
            <i class="fa fa-css3"></i>
        </div>

        <div class="elements-container dflex">

            <a class="element" href="Deshboardf.php">
                <i class="fa fa-dashboard"></i> Dashboard
            </a>
            <a class="element" href="suggestions.php">
                <i class="fa fa-leaf"></i> Suggestions
            </a>
            <a class="element" href="AddProject.php">
                <i class="fa fa-pencil-square-o"></i> Add Projects
            </a>
            <a class="element" href="request.php">
                <i class="fa fa-hourglass-start"></i> Pending Requests
            </a>
            <a class="element" href="changepswd.php">
                <i class="fa fa-cogs"></i> Change Password
        </a>
            <a class="element" href="logout.php">
                <i class="fa fa-sign-out"></i> Logout
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
        window.addEventListener("click", function (event) {
            if (event.target == document.getElementById("myModal")) {
                closeModal();
            }
        });
    </script>

    
<div class="heading-container">
            <h2 class="heading">Student Suggestions</h2>
            <p class="sub-heading">Give them a Chance!</p>
        </div>

          
        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-info">
                    <tr>
            <th> Given By </th>
            <th> Project-Title </th>
            <th> Project-Description </th>
            <th> Project-Outcome </th>
            <th> Time </th>
            <th> Action </th> <!-- Add this column for the ADD button -->
        </tr>
    </thead>
        <?php
        $i = 0;
        while ($rows = mysqli_fetch_assoc($result)) {
            $i++;
        ?>
            <tr>
                <td><?php echo $rows['Sname']; ?></td>
                <td><?php echo $rows['ProjectTitle']; ?></td>
                <td><?php echo $rows['ProjectDesc']; ?></td>
                <td><?php echo $rows['ProjectOutcome']; ?></td>
                <td><?php echo $rows['Time']; ?></td>
                <td>
                    <?php
                    if ($rows['status'] == 'pending') {
                    ?>
                        <form action="" method="POST" style="margin: 0;">
                            <input type="hidden" name="suggestionId" value="<?php echo $rows['sid']; ?>">
                            <input class="btn btn-success" name="ADD_<?php echo $i; ?>" type="submit" value="ADD">
                        </form>
                    <?php
                    } else {
                    ?>
                        <button type="button" disabled> ADD</button>
                    <?php
                    }
                    ?>
                </td>
            </tr>
        <?php
        }
        ?>

    </table></div>
    </body>
    </html>
    <?php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $suggestionId = mysqli_real_escape_string($conn, $_POST['suggestionId']);

    // Retrieve the values from the suggestion table
    $selectQuery = "SELECT ProjectTitle, ProjectDesc FROM suggestion WHERE sid = $suggestionId";
    $result = mysqli_query($conn, $selectQuery);

    if ($result) {
        $fid=$_SESSION['id'];
        $row = mysqli_fetch_assoc($result);
        $projectTitle = mysqli_real_escape_string($conn, $row['ProjectTitle']);
        $projectDesc = mysqli_real_escape_string($conn, $row['ProjectDesc']);

        // Insert the values into the record table
        $insertQuery = "INSERT INTO record (fid,ProjectTitle, ProjectDesc) VALUES ('$fid','$projectTitle', '$projectDesc')";
        $updateQuery = "UPDATE  suggestion set status='approved' where sid=$suggestionId";
        $result1=mysqli_query($conn,$updateQuery);
        $result2=mysqli_query($conn,$insertQuery);
        if ($result1 && $result2){
            echo '<script>
            document.getElementById("popupMessage").innerHTML = "Suggestion Added To The Project Ideas List!";
            document.getElementById("myModal").style.display = "block";
        </script>';
        }else {
            echo "Error: " . $insertQuery . "<br>" . mysqli_error($conn);
        }

    } else {
        echo "Error: " . $selectQuery . "<br>" . mysqli_error($conn);
    }
}
?>