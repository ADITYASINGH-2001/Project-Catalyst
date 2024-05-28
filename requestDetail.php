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
$fid=$_SESSION['id'];
$query = "select * from `request`";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Requests</title>
    <link rel="stylesheet" href="mystyle.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
</head>
<body>
    <!-- Code to insert vertical sidebar -->
    <input type="checkbox" id="menu-toggle" checked>
    <div class="menu dflex">
        <div id="logoCSS3" class="text-center">
            <i class="fa fa-css3"></i>
        </div>
        <div class="elements-container dflex">
            <a class="element" href="DashboardA.php">
                <i class="fa fa-money"></i> Student Record
            </a>
            <a class="element" href="requestDetail.php">
                <i class="fa fa-money"></i> Request Details
            </a>
            <a class="element" href="logout.php">
                <i class="fa fa-cogs"></i> Logout
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
    <h1 style="text-align:center">Requests Status</h1>
    <table>
    <!-- align="center" border="1px" style="color:white; width:800px; line-height:40px;" -->
        <tr>
        <th> Requested By </th>
        <th> Requested To </th>
        <th> Requested For </th>
        <th> Status </th>
        </tr>
        <?php
        while ($rows = mysqli_fetch_assoc($result)) {
            $fid = $rows['fid'];
            $id = $rows['id'];
            $innerquery = "SELECT `name` FROM `users` WHERE `id` = '$fid'";
            $innerResult = mysqli_query($conn, $innerquery);
            $fname="";
            $innerquery = "SELECT `name` FROM `users` WHERE `id` = '$id'";
            $innerResult2 = mysqli_query($conn, $innerquery);
            $Sname="";
            if ($innerResult && $innerResult2) {
                
                    $rowa = mysqli_fetch_assoc($innerResult);
                    $fname = $rowa['name'];
                    
                    $rowa = mysqli_fetch_assoc($innerResult2);
                    $Sname = $rowa['name'];
            } else {
                echo "Error in the query: " . mysqli_error($conn);
            }
        
        ?>
            <tr>
                <td><?php echo $Sname ?></td>
                <td><?php echo $fname ?></td>
                <td><?php echo $rows['ProjectTitle']; ?></td>
                <td><?php echo $rows['status']; ?></td>
            </tr>
        <?php
        }
        ?>
    </table>
    
</body>
</html>
