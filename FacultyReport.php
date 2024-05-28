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
function call()
{
  global $conn;
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['options'] == 'students') {
      // return (getTotalStudents());
      $fid = $_SESSION['id'];
      $query = "SELECT * FROM student WHERE pid in (select pid from record where fid=$fid)";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) > 0) {
        echo '<table>
                
                    <tr class="table-info">
                        <th>Student Name</th>
                        <th>Course</th>
                        <th>Section</th>
                        <th>Project</th>
                        <th>Progress</th>
                    </tr>';

        while ($row = mysqli_fetch_assoc($result)) {
          global $projectTitle;
          $pid = $row['pid'];
          $pr = "SELECT ProjectTitle FROM record WHERE pid=$pid";
          $resultt = mysqli_query($conn, $pr); // Fixing the query variable name
          if ($resultt) {
            $projectRow = mysqli_fetch_assoc($resultt); // Fetching the row
            $projectTitle = $projectRow['ProjectTitle']; // Extracting ProjectTitle

          }
          echo '<tr>
                                  <td>' . $row['StudentName'] . '</td>
                                  <td>' . $row['course'] . '</td>
                                  <td>' . $row['sec'] . '</td>
                                  <td>' . $projectTitle . '</td> 
                                  <td>' . $row['progress'] . '</td>
                                  </tr>';
        }
        echo '</table>';
      } else {
        echo '<p>No Students found.</p>';
      }
    }



    if ($_POST['options'] == 'requests') {
      $query = "SELECT * FROM request";
      $result = mysqli_query($conn, $query);

      if (mysqli_num_rows($result) > 0) {
        echo '<table>
                    <tr class="table-info">
                    <th>Student Name</th>
                    <th>Project Title</th>
                    <th>Status</th>
                    </tr>';
        while ($row = mysqli_fetch_assoc($result)) {
          echo '<tr>
              <td>' . $row['Sname'] . '</td>
              <td>' . $row['ProjectTitle'] . '</td>
              <td>' . $row['status'] . '</td>
              </tr>';
        }
        echo '</table>';
      } else {
        echo '<p>No Reports found.</p>';
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
  <style>
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
  </style>
  <!-- Add this script for the print functionality -->
  <script>
    function printData() {
      window.print();
    }
  </script>


</head>

<body>
  <!-- <input type="button" onclick="printData()" style="position: fixed; top: 10px; right: 50px;" value="Print"> -->
  <!--Code to insert vertical sidebar -->
  <input type="checkbox" id="menu-toggle" checked>
  <div class="menu dflex">
    <div id="logoCSS3" class="text-center">
      <i class="fa fa-css3"></i>
    </div>
    <div class="elements-container dflex">
      <a class="element" href="Deshboardf.php">
        <i class="fa fa-leaf"></i> Dashboard
      </a>
      <a class="element" href="suggestions.php">
        <i class="fa fa-gavel"></i> Suggestions
      </a>
      <a class="element" href="AddProject.php">
        <i class="fa fa-cogs"></i> Add Projects
      </a>
      <a class="element" href="request.php">
        <i class="fa fa-cogs"></i> Pending Requests
      </a>
      <a class="element" href="logout.php">
        <i class="fa fa-cogs"></i> Logout
      </a>
      <a class="element" href="changepswd.php">
        <i class="fa fa-cogs"></i> Change Password
      </a>
      <a class="element" href="Report.php">
        <i class="fa fa-cogs"></i> Report
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
  <h2 style="text-align:center;padding-top:20px;">Select Report Type</h2>
  <div style="text-align:center;margin-left:748px;">
    <div class="center-content">
      <div class="container">
        <div class="row">
          <div class="col-md-3" style="text-align: left;">
            <form id="reportForm" method="POST" action="">
              <label for="options" class="form-label">Select an option:</label>
              <select name="options" id="options" class="form-select">
                <option value="students">No of Students</option>

                <option value="requests">Requests</option>
              </select>
              <button type="submit" class="btn btn-primary" style="margin-top:10px;">Generate</button>
            </form>

          </div>
        </div>

      </div>
    </div>
  </div>

  <div><?php echo call(); ?></div>


</body>

</html>