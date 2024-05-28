<?php
$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "my_db";
$conn = mysqli_connect($sname, $uname, $password, $db_name);
session_start();
if (!$conn) {
    echo "Connection failed";
    exit();
}
$sname= $_SESSION['name'];
$query = "select * from `record`";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="mystyle.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
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

        .men {
            font-size: 20px;
            color: white;
        }

        body {
            margin: 0;
            padding: 0;
        }

        .background-container {
            background-image: url('path/to/your/image.jpg');
            background-size: cover;
            background-attachment: fixed;
            height: 5vh; /* Adjust as needed */
            overflow: hidden; /* Prevent scrollbars in the background container */
        }

        .content-container {
            padding: 20px;
            overflow-y: auto; /* Enable scrolling for the content */
            height: 100vh; /* Adjust as needed */
            box-sizing: border-box;
        }

        .table th, .table td {
            vertical-align: middle;
            text-align: center;
        }

        .modal1 {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgb(0, 0, 0);
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            text-align: center;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }

        
    </style>
    </style>
</head>

<body>
    <div class="background-container"></div>
    <div class="content-container">
        <input type="checkbox" id="menu-toggle" checked>
        <div class="menu dflex">
            <div id="logoCSS3" class="text-center">
                <a class="element">
                    <img style="width:150px; height:170px;" src="downloadlogo.png" alt="logo">
                </a>
            </div>
            <div class="elements-container dflex">
                <a class="element" href="myproject.php">
                    <i class="fa fa-dashboard"></i> Project Dashboard
                </a>
                <a class="element" href="Dashboard.php">
                    <i class="fa fa-navicon"></i> Project Ideas
                </a>
                <a class="element" href="my_request.php">
                    <i class="fa"></i> --->My Requests
                </a>
                <a class="element" href="suggest.php">
                    <i class="fa fa-pencil-square-o"></i> Give Suggestions
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
            window.addEventListener("click", function(event) {
                if (event.target == document.getElementById("myModal")) {
                    closeModal();
                }
            });
        </script>
 <div class="heading-container">
            <h2 class="heading">Projects</h2>
            <p class="sub-heading">Explore and request projects</p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-info">
                    <tr>
                        <th>Faculty Name</th>
                        <th>Project ID</th>
                        <th>Project Title</th>
                        <th>Project Description</th>
                        <th>SDG Level</th>
                        <th>Status</th>
                        <th>Request</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        while ($row = mysqli_fetch_assoc($result)) {
                            $fid = $row['fid'];
                            $innerquery = "SELECT `name` FROM `users` WHERE `id` = '$fid'";
                            $innerResult = mysqli_query($conn, $innerquery);
                            $name = "";
                            if ($innerResult) {
                                if (mysqli_num_rows($innerResult) == 1) {
                                    $rowa = mysqli_fetch_assoc($innerResult);
                                    $name = $rowa['name'];
                                } else {
                                    echo "Invalid credentials. Please try again later.";
                                }
                            } else {
                                echo "Error in the query: " . mysqli_error($conn);
                            }
                    ?>
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $row['pid']; ?></td>
                        <td><?php echo $row['ProjectTitle']; ?></td>
                        <td><?php echo $row['ProjectDesc']; ?></td>
                        <td><?php echo $row['SDG']; ?></td>
                        <td style="background-color: <?php echo ($row['Status'] == 1) ? 'lightgreen' : 'rgb(255, 127, 127)'; ?>;">
                            <?php echo ($row['Status'] == 1) ? 'Available' : 'Unavailable'; ?>
                        </td>
                        <td>
                            <?php 
                            $id = $_SESSION['id'];
                            $existingUser = "SELECT * FROM `request` WHERE `id`='$id' and `status`='approved'";
                            $existingUserquery = mysqli_query($conn, $existingUser);

                            if ($row['Status'] == 1 && mysqli_num_rows($existingUserquery) == 0) {
                            ?>
                            <form action="" method="POST">
                                <input type="hidden" name="id" value="<?php echo $row['fid']; ?>" />
                                <input type="hidden" name="id" value="<?php echo $row['ProjectTitle']; ?>" />
                                <input type="submit" name="request_<?php echo $row['pid']; ?>" value="Request" class="btn btn-primary btn-sm">
                            </form>
                            <?php } else { ?>
                            <button type="button" class="btn btn-secondary btn-sm" disabled>Request</button>
                            <?php }
                            if (isset($_POST["request_" . $row['pid']])) {
                                $pid = $row['pid'];
                                $fid = $row['fid'];
                                $pt = $row['ProjectTitle'];
                                // Ensure to sanitize user inputs before inserting into the database to prevent SQL injection
                                $pt = mysqli_real_escape_string($conn, $pt);
                                $pid = mysqli_real_escape_string($conn, $pid);
                                $fid = mysqli_real_escape_string($conn, $fid);
                                
                                // Check if the user has already requested the same project
                                $existingRequestQuery = "SELECT * FROM `request` WHERE `pid`='$pid' AND `fid`='$fid' AND `Sname`='$sname'";
                                $existingRequestResult = mysqli_query($conn, $existingRequestQuery);

                                if (mysqli_num_rows($existingRequestResult) > 0) {
                                    // User has already requested this project
                                    echo '<script>
                                    document.getElementById("popupMessage").innerHTML = "You have already requested for this project!";
                                    document.getElementById("myModal").style.display = "block";
                                </script>';
                                } else {
                                    $id = $_SESSION['id'];
                                    $sql = "INSERT INTO `request` (`id`,`pid`,`fid`,`Sname`, `ProjectTitle`,`status`) VALUES('$id','$pid','$fid','$sname', '$pt','pending');";
                                    $query = mysqli_query($conn, $sql);
                                    if ($query) {
                                        echo '<script>
                                        document.getElementById("popupMessage").innerHTML = "Your request has been submitted successfully";
                                        document.getElementById("myModal").style.display = "block";
                                    </script>';
                                    } else {
                                        echo "Error inserting request: " . mysqli_error($conn);
                                    }
                                }
                            }
                            ?>
                        </td>
                    </tr>
                    <?php
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>
