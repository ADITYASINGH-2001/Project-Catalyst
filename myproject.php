













<?php
// Set the default time zone to Indian Standard Time
date_default_timezone_set('Asia/Kolkata');

include_once("db_conn.php");
session_start();
$id = $_SESSION['id'];
$student_id = $_SESSION['username'];
$query = "SELECT * FROM student,record where record.pid = student.pid AND student.id=$id";
$result = mysqli_query($conn, $query);

$unread_notifications_query = "SELECT COUNT(*) AS unread_count FROM notifications WHERE sid = '$student_id' AND status = 0";
$unread_notifications_result = mysqli_query($conn, $unread_notifications_query);
$unread_notifications_row = mysqli_fetch_assoc($unread_notifications_result);
$unread_count = $unread_notifications_row['unread_count'];

// Update read status if notifications are viewed
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['mark_as_read'])) {
    $update_read_status_query = "UPDATE notifications SET read_status = 1 WHERE sid = '$student_id' AND status = 0";
    mysqli_query($conn, $update_read_status_query);
    // Redirect to prevent form resubmission
    //header("Location: student_dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Student-Deshboard</title>
    <link rel="stylesheet" href="mystyle.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .upload-form {
            margin-top: 20px;
            padding: 15px;
            border: 1px solid #ccc;
            border-radius: 8px;
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

        h1 {
            text-align: center !important;
            padding: 20px;
            font-family: 'Roboto', sans-serif;

        }

        .container {
            width: 80%;
            padding: 20px;
            text-align: center;

        }

        .mainbody {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 90vh;
        }

        .project {
            margin-top: 0px;
            margin-bottom: 20px;
            background: rgba(255, 255, 255, 0.1);
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .project h3 {
            font-size: 24px;
            color: #42b883;
            margin-bottom: 10px;
        }

        .project p {
            font-size: 18px;
            line-height: 1.6;
            color: #f0f0f0;
            margin-bottom: 20px;
        }

        .progress {
            height: 20px;
            margin-top: 20px;

        }

        .progress-bar {
            background-color: #42b883;
        }

        .work-completed {
            font-size: 20px;
            color: #42b883;
            margin-bottom: 10px;
        }

        .notification-dot {
            position: absolute;
            top: 0;
            left: 90%;
            width: 10px;
            height: 10px;
            background-color: yellow;
            border-radius: 50%;
            color: yellow;
        }

        #logo-container {
            position: fixed;
            top: 0%;
            /* Adjust as needed */
            left: 2%;
            /* Adjust as needed */
            transform: translateY(-50%);
            /* Center the logo vertically */
            animation: rotate 2s linear infinite alternate;
            /* Adjust animation duration as needed */
        }

        @keyframes rotate {
            0% {
                transform: translateX(0) rotateY(0);
            }

            /* Start with no rotation */
            100% {
                transform: rotateY(90deg);
            }

            /* Rotate 180 degrees */
        }

        /* Style to ensure text remains readable */
        #logo-container img {
            width: 100px;
            /* Adjust as needed */
            height: auto;
            /* Preserve aspect ratio */
            transform: rotateY(0);
            /* Ensure the image remains readable */
        }
    </style>
</head>

<body>

    <!-- Code to insert vertical sidebar -->

    <div class="background-container"> </div>
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
                <a class="element" href="suggest.php">
                    <i class="fa fa-pencil-square-o"></i> Give Suggestions
                </a>
                <a class="element" href="logout.php">
                    <i class="fa fa-sign-out"></i> Logout
                </a>
                <a class="element" href="changepswd.php">
                    <i class="fa fa-cogs"></i> Change Password
                </a>
                <!-- <a class="element" href="AdminReport.php">
                    <i class="fa fa-cogs"></i> Generate Report
                </a> -->
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
        <div style="position: relative; left: 90%; padding-top: 20px;">
            <a href="view_notifications.php" style="text-decoration: none; display: flex; align-items: center;">
                <i class="fa fa-bell" style="font-size:34px; color:red;"></i>
                <span style="background-color: black; color: white; border-radius: 50%; padding: 5px 10px; font-size: 10px; margin-left: -10px;"><?php echo $unread_count; ?></span>
            </a>
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
        <div id="logo-container">
            <img src="downloadlogo2.png" alt="Project Catalyst Logo" style="width: 150px; height: 150px;">
        </div>
        <h1>My Project</h1>
        <div class="mainbody">

            <div class="container">
                <?php
                if (mysqli_num_rows($result) == 0) {
                    echo "Sorry, Currently
            you don't have any project to show!";
                }
                while ($rows = mysqli_fetch_assoc($result)) {
                    $fid = $rows['fid'];
                    $que = "Select `name` from `users` where `id` = $fid";
                    $fname = mysqli_query($conn, $que);
                    $name = mysqli_fetch_assoc($fname);

                ?>

                    <div class="project">
                        <h3><?php echo $rows['ProjectTitle']; ?></h3>
                        <p><?php echo $rows['ProjectDesc']; ?></p>
                        <b><p>Project Supervisor: <?php echo $name['name'] ?></p></b>
                        <div class="work-completed">My Progress</div>
                        <div class="progress">
                            <div class="progress-bar" role="progressbar" style="width: <?php echo $rows['progress']; ?>%;" aria-valuenow="<?php echo $rows['progress']; ?>" aria-valuemin="0" aria-valuemax="100"><?php echo $rows['progress']; ?>%</div>
                        </div>

                    </div>
                    <form action="" method="post" enctype="multipart/form-data">
                        <label for="document_type">Select Document Type:</label>
                        <select name="document_type" id="document_type">
                            <option value="synopsis">Synopsis</option>
                            <option value="srs">SRS</option>
                            <option value="finalReport">Final Report</option>
                            <option value="presentation 1">Presentation 1</option>
                            <option value="presentation 2">Presentation 2</option>
                            <option value="presentation 3">Presentation 3</option>
                        </select>
                        <label for="file">Upload File:</label>
                        <input class="btn btn-warning" type="file" name="file" accept=".pdf, .docx, .zip, .rar">
                        <input type="hidden" id="pid" name="pid" value="<?php echo $rows['pid']; ?>">
                        <input type="submit" value="Upload Document">
                    </form>
                <?php } ?>
            </div>
        </div>

        <?php
        // // Connect to the database (similar to your existing code)
        // $sname = "localhost";
        // $uname = "root";
        // $password = "";
        // $db_name = "my_db";
        // $conn = mysqli_connect($sname, $uname, $password, $db_name);
        // if (!$conn) {
        //     echo "Connection failed";
        //     exit();
        // }
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $pid = $_POST['pid'];
            $document_type = $_POST['document_type'];

            // Check if upload is allowed based on the expiration date
            $expiration_query = "SELECT synopsis FROM timer";
            $expiration_result = mysqli_query($conn, $expiration_query);
            $expiration_row = mysqli_fetch_assoc($expiration_result);
            $expiration_date = $expiration_row['synopsis'];

            // Get the current time
            $current_time = date('Y-m-d H:i:s');

            if ($current_time > $expiration_date) {
                echo '<script>
                    document.getElementById("popupMessage").innerHTML = "Upload period for this document type has expired";
                    document.getElementById("myModal").style.display = "block";
                </script>';
                exit();
            }

            // Process the uploaded file
            $file_name = $_FILES['file']['name'];
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_type = $_FILES['file']['type'];
            $file_size = $_FILES['file']['size'];
            $unique_filename = uniqid() . '_' . $file_name;
            // You may want to add more file validation (e.g., file type, size, etc.)
            if ($file_tmp == null) {
                echo '<script>
                    document.getElementById("popupMessage").innerHTML = "Kindly select a document first";
                    document.getElementById("myModal").style.display = "block";
                </script>';

                exit();
            }
            // Read the file content
            $file_content = file_get_contents($file_tmp);

            // Get the current time
            $upload_time = date('Y-m-d H:i:s');

            // Update the student table with the uploaded document and time
            $update_query = "UPDATE student SET progress=?, $document_type=?, time=? WHERE pid=?";
            // $stmt = mysqli_prepare($conn, $update_query);
            // mysqli_stmt_bind_param($stmt, "ssi", $file_content, $upload_time, $pid);
            // mysqli_stmt_execute($stmt);


            $result2 = mysqli_query($conn, $query);
            $rows = mysqli_fetch_assoc($result2);

            if ($document_type == 'synopsis') {
                    $pro=20;
                    $file_column = 'synopsis';
                    $filename_column = 'synopsis_filename';
            } elseif ($rows['synopsis'] != null && $document_type == 'srs') {
                $pro=50;
            $file_column = 'srs';
            $filename_column = 'srs_filename';
            } elseif ($rows['srs'] != null && $document_type == 'finalReport') {
                $pro=60;
                $file_column = 'finalReport';
                $filename_column = 'finalReport_filename';
            } elseif ($rows['finalReport'] != null && $document_type == 'presentation 1') {
                $pro=70;
                $file_column = 'presentation1';
                $filename_column = 'presentation1_filename';
            } elseif ($rows['presentation 1'] != null && $document_type == 'presentation 2') {
                $pro=80;
                $file_column = 'presentation2';
                $filename_column = 'presentation2_filename';
            } elseif ($rows['presentation 2'] != null && $document_type == 'presentation 3') {
                $pro=90;
                $file_column = 'presentation3';
                $filename_column = 'presentation3_filename';
            } else {
                echo '<script>
                    document.getElementById("popupMessage").innerHTML = "Invalid Ordering";
                    document.getElementById("myModal").style.display = "block";
                </script>';
                exit();
            }
            
        $update_query = "UPDATE student SET progress=?, $file_column=?, $filename_column=?, time=? WHERE pid=?";
        $stmt = mysqli_prepare($conn, $update_query);
        mysqli_stmt_bind_param($stmt, "ssssi", $pro, $file_content, $unique_filename, $upload_time, $pid);
        mysqli_stmt_execute($stmt);
            if (mysqli_affected_rows($conn) > 0) {

                echo '<script>
                    document.getElementById("popupMessage").innerHTML = "Document uploaded successfully!";
                    document.getElementById("myModal").style.display = "block";
                </script>';
            } else {
                echo '<script>
                    document.getElementById("popupMessage").innerHTML = "Error uploading document ";
                    document.getElementById("myModal").style.display = "block";
                </script>';
            }
        }
        ?>

</body>

</html>
