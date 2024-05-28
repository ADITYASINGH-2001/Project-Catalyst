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
$username = $_SESSION['username'];


// Use prepared statements to avoid SQL injection
$sql = "SELECT `sec` FROM coordinator WHERE `username` = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "s", $username);
mysqli_stmt_execute($stmt);
$result2 = mysqli_stmt_get_result($stmt);

if ($result2) {
    $row = mysqli_fetch_assoc($result2);
    $sec = $row['sec'];

    // Use prepared statements to avoid SQL injection
    $query = "SELECT * FROM `student` WHERE sec = ?";
    $stmt2 = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt2, "s", $sec); // Assuming `sec` is a string. Change "s" to "i" if `sec` is an integer.
    mysqli_stmt_execute($stmt2);
    $result = mysqli_stmt_get_result($stmt2);

}    
?>
<!DOCTYPE html> 
<html> 
	<head> 
		<title>Faculty-Deshboard</title> 
    <link rel="stylesheet" href="mystyle.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
    .table-responsive {
        margin-right:100px;
        overflow-x: auto; /* Ensure horizontal scrolling if the content overflows */
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
  <input type="button" onclick="printData()" style="position: fixed; top: 10px; right: 50px;" value="Print">
    <!--Code to insert vertical sidebar -->

<input type="checkbox" id="menu-toggle" checked>
<div class="menu dflex">
  <div id="logoCSS3" class="text-center">
    <i class="fa fa-css3"></i>
  </div>
  <div class="elements-container dflex" >
 
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

<div class="heading-container">
            <h2 class="heading">My Section</h2>
            <p class="sub-heading">Explore and Evaluate The Efforts</p>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered table-hover">
                <thead class="table-info">
                    <tr>
          <th>S.No.</th>
          <th> Student-Name </th> 
          <th> Project-Id</th> 
          <th> Project-Title </th>
          <th> Synopsis </th>
          <th> SRS</th>
          <th> Final Report</th>
          <th> Work Completion Status</th> 
        </tr></thead>
		 
		
		<?php 
    $i=1;
    while($rows=mysqli_fetch_assoc($result))  
		{ 
            $projectTitle="NULL";
            if($rows['pid']){
                $pid=$rows['pid'];
                $internal="SELECT ProjectTitle from record where pid=$pid";
                $result2=mysqli_query($conn,$internal);
                $row2=mysqli_fetch_assoc($result2);
                $projectTitle=$row2['ProjectTitle'];
            }
		?> 
		<tr> <td> <?php echo $i++.'.';?></td>
      <td><?php echo $rows['StudentName']; ?></td> 
		<td><?php echo $rows['pid']; ?></td> 
		<td><?php echo $projectTitle; ?></td> 
    <td> <?php
    if ($rows['synopsis'] != null) {
      
      echo '<a href="download.php?filename=' . $rows['synopsis_filename'] . '&file_column=synopsis">Download</a>';


  } else {
      echo 'No document available';
  }
    ?></td> 
    <td><?php  if ($rows['srs'] != null) {
      
      echo '<a href="download.php?filename=' . $rows['srs_filename'] . '&file_column=srs">Download</a>';


  } else {
      echo 'No document available';
  } ?></td> 
    <td><?php  if ($rows['finalReport'] != null) {
      
      echo '<a href="download.php?filename=' . $rows['finalReport_filename'] . '&file_column=finalReport">Download</a>';


  } else {
      echo 'No document available';
  } ?></td> 
    <td><div class="progress">
                    <div class="progress-bar" role="progressbar"
                        style="width: <?php echo $rows['progress']; ?>%;" aria-valuenow="<?php echo $rows['progress']; ?>"
                        aria-valuemin="0" aria-valuemax="100"><?php echo $rows['progress']; ?>%</div>
                </div></td> 
    <td style="border:none!important"><a href="edit_progress.php?id=<?php echo $rows['id']; ?>" class="btn btn-primary no-border">Edit Progress</a></td>
        
		</tr> 
	<?php 
               } 
          ?> 

	</table> 
              </div>
	</body> 
	</html>