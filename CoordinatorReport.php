<?php
$sname = "localhost";
$uname = "root";
$password = "";
$db_name = "my_db";
$conn = mysqli_connect($sname, $uname, $password, $db_name);
if (!$conn) {
    echo "Connection failed";
    exit();
}
session_start();

function call()
{
    global $conn;
    $username = $_SESSION['username'];
    $sql = "SELECT `sec` FROM coordinator WHERE `username` = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result2 = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result2);
    $sec1 = $row['sec'];

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if ($_POST['options'] == 'student') {
            $query = "SELECT * FROM student WHERE sec = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $sec1); // Assuming sec is a string. Use "i" if it's an integer.
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                echo '<div id="report-section" class="table-responsive">
                <table class="table table-bordered table-hover">
                <thead class="table-info">
                <tr>
                              <th>Student Name</th>
                              <th>Course</th>
                              <th>Section</th>
                              <th>Email</th>
                              <th>Project</th>
                              <th>Progress</th>
                          </tr></thead>';

                while ($row = mysqli_fetch_assoc($result)) {
                    global $projectTitle;
                    $pid = $row['pid'];
                    if ($pid) {
                        $pr = "SELECT ProjectTitle FROM record WHERE pid=$pid";
                        $resultt = mysqli_query($conn, $pr);
                        if ($resultt) {
                            $projectRow = mysqli_fetch_assoc($resultt);
                            $projectTitle = $projectRow['ProjectTitle'];
                        }
                    } else {
                        $projectTitle = "NOT WORKING";
                    }
                    if ($row['progress'] == NULL) {
                        $row['progress'] = 0;
                    }
                    echo '<tr>
                                        <td>' . $row['StudentName'] . '</td>
                                        <td>' . $row['course'] . '</td>
                                        <td>' . $row['sec'] . '</td>
                                        <td>' . $row['mailId'] . '</td>
                                        <td>' . $projectTitle . '</td> 
                                        <td>' . $row['progress'] . '</td>
                                        </tr>';
                }
                echo '</table></div>';
            } else {
                echo '<p id="report-section">No Students found.</p>';
            }
        }

        if ($_POST['options'] == 'master') {
            $query = "SELECT * FROM student WHERE sec = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "s", $sec1);
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);

            if (mysqli_num_rows($result) > 0) {
                echo '<div id="report-section" class="table-responsive">
                <table class="table table-bordered table-hover">
                <thead class="table-info">
                <tr>
                              <th>Student Name</th>
                              <th>Course</th>
                              <th>Section</th>
                              <th>Project Title</th>
                              <th>Project Description</th>
                              <th>Project Technology</th>
                              <th>Project SDG Level</th>
                              <th>Progress</th>
                          </tr> </thead>';

                while ($row = mysqli_fetch_assoc($result)) {
                    global $projectTitle, $projectDesc, $projectTech, $projectSDG;
                    $pid = $row['pid'];
                    if ($pid) {
                        $pr = "SELECT ProjectTitle, ProjectDesc, ProjectTech, SDG FROM record WHERE pid=$pid";
                        $resultt = mysqli_query($conn, $pr);
                        if ($resultt) {
                            $projectRow = mysqli_fetch_assoc($resultt);
                            $projectTitle = $projectRow['ProjectTitle'];
                            $projectDesc = $projectRow['ProjectDesc'];
                            $projectTech = $projectRow['ProjectTech'];
                            $projectSDG = $projectRow['SDG'];
                        }
                    } else {
                        $projectTitle = "NULL";
                        $projectDesc = "NULL";
                        $projectTech = "NULL";
                        $projectSDG = "NULL";
                    }
                    echo '<tr>
                                        <td>' . $row['StudentName'] . '</td>
                                        <td>' . $row['course'] . '</td>
                                        <td>' . $row['sec'] . '</td>
                                        <td>' . $projectTitle . '</td> 
                                        <td>' . $projectDesc . '</td> 
                                        <td>' . $projectTech . '</td> 
                                        <td>' . $projectSDG . '</td> 
                                        <td>' . $row['progress'] . '</td>
                                        </tr>';
                }
                echo '</table></div>';
            } else {
                echo '<p id="report-section">No Students found.</p>';
            }
        }

        if ($_POST['options'] == 'request') {
            $query = "SELECT * FROM request WHERE id IN (SELECT `id` FROM student WHERE sec='$sec1')";
            $result = mysqli_query($conn, $query);

            if (mysqli_num_rows($result) > 0) {
                echo '<div id="report-section" class="table-responsive">
                <table class="table table-bordered table-hover">
                <thead class="table-info">
                <tr>
                        <th>Requested By</th>
                        <th>Requested To</th>
                        <th>Requested For</th>
                        <th>Status</th>
                    </tr>
                </thead>';

                while ($rows = mysqli_fetch_assoc($result)) {
                    $fid = $rows['fid'];
                    $id = $rows['id'];
                    $innerquery1 = "SELECT name FROM users WHERE id = '$fid'";
                    $innerquery2 = "SELECT name FROM users WHERE id = '$id'";
                    $innerResult1 = mysqli_query($conn, $innerquery1);
                    $innerResult2 = mysqli_query($conn, $innerquery2);
                    $fname = $Sname = "";
                    if ($innerResult1 && $innerResult2) {
                        $rowa = mysqli_fetch_assoc($innerResult1);
                        $fname = $rowa['name'];
                        $rowa = mysqli_fetch_assoc($innerResult2);
                        $Sname = $rowa['name'];
                    } else {
                        echo "Error in the query: " . mysqli_error($conn);
                    }
                    echo '<tr>
                            <td>' . $Sname . '</td>
                            <td>' . $fname . '</td>
                            <td>' . $rows['ProjectTitle'] . '</td>
                            <td>' . $rows['status'] . '</td>
                        </tr>';
                }
                echo '</table></div>';
            } else {
                echo '<p id="report-section">No Reports found.</p>';
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Report</title>
    <link rel="stylesheet" href="mystyle.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .cen {
            position: static;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .student-list {
            list-style-type: none;
            padding: 0;
        }

        .student-list li {
            margin-bottom: 5px;
            font-size: 16px;
        }

        .progress {
            height: 20px;
            margin-top: 20px;
        }

        .progress-bar {
            background-color: #42b883;
        }

        @media print {
            body * {
                visibility: hidden;
            }

            #printable-content,
            #printable-content * {
                visibility: visible;
            }

            #printable-content {
                position: absolute;
                left: 0;
                top: 0;
            }
        }

        .center-content {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 20vh;
        }

        #output {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
        }

        .table-responsive {
            overflow-x: auto;
        }

        .table th,
        .table td {
            padding: 10px;
            word-wrap: break-word;
        }

        .table th {
            width: 150px;
        }

        .table td {
            width: 200px;
        }
    </style>
    <!-- Add this script for the print functionality -->
    <script>
        function printData() {
            window.print();
        }

        window.onload = function () {
            setTimeout(function () {
                if (document.getElementById('report-section')) {
                    document.getElementById('report-section').scrollIntoView({ behavior: 'smooth' });
                }
            }, 1000); // 500 milliseconds delay before scrolling
        };
    </script>

</head>`

<body>
    <input type="checkbox" id="menu-toggle" checked>
    <div class="menu dflex">
        <div id="logoCSS3" class="text-center">
            <i class="fa fa-css3"></i>
        </div>
        <div class="elements-container dflex">
            
                <a class="element" href="DashboardC.php">
                    <i class="fa fa-dashboard"></i> Dashboard
                </a>
                <a class="element" href="CoordinatorReport.php">
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
    <div class="container d-flex justify-content-center align-items-center" style="min-height:100vh; color:white;">
        <div style="box-shadow: 0 0 10px 2px rgba(255, 255, 255, 0.5); background-color: #333; padding: 20px; border-radius: 10px;">
            <form id="reportform" action="" method="POST" class="border shadow p-3 rounded">
                <h1 class="text-center p-3 mb-5 colbl" style="background-color: #555; padding: 10px; border-radius: 5px; font-family: 'Arial', sans-serif; font-size: 24px; text-transform: uppercase; letter-spacing: 2px;">Select the report type</h1>
                <label for="options" class="form-label">Select an option:</label>
                <select name="options" id="options" class="form-select">
                    <option value="student">Students Status</option>
                    <option value="request">Student Request Report</option>
                    <option value="master">Master Report</option>
                </select>
                <button type="submit" class="btn btn-primary" style="margin-top:10px;">Generate</button>
            </form>
        </div>
    </div>
    <div><?php call(); ?></div>
</body>

</html>
