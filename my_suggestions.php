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

$sname = $_SESSION['username'];

// Retrieve suggestions for the logged-in student
$sql = "SELECT * FROM suggestion WHERE Sname = '$sname'";
$result = mysqli_query($conn, $sql);

if (!$result) {
    echo "Error: " . mysqli_error($conn);
    exit();
}
?>

<html>
<head>
    <title>My Suggestions - Project Link Hub</title>
    <!-- Add your stylesheets and other head content here -->
    <link rel="stylesheet" href="mystyle.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
          form {
            margin: 0;
        }
   </style>
</head>
<body>

<!--
    Code to insert vertical sidebar 
-->

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
            <a class="element" href="my_suggestions.php">
                <i class="fa "></i> --->My Suggestions
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

<div class="container">
    <h1 class="text-center p-3 mb-5 colbl">My Suggestions</h1>
    <?php
    // Display the suggestions in a table
    if (mysqli_num_rows($result) > 0) {
        echo '<table>
                
                    <tr class="table-info">
                        <th>Project Title</th>
                        <th>Project Description</th>
                        <th>Time</th>
                        <th>Status</th>
                    </tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            echo '<tr>
                    <td>' . $row['ProjectTitle'] . '</td>
                    <td>' . $row['ProjectDesc'] . '</td>
                    <td>' . $row['Time'] . '</td>
                    <td>' . $row['status'] . '</td>
                  </tr>';
        }

        echo '</table>';
    } else {
        echo '<p>No suggestions found.</p>';
    }

    mysqli_close($conn);
    ?>

</div>

</body>
</html>
