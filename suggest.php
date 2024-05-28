<?php session_start(); 
$sname="localhost";
$uname="root";
$password="";
$db_name="my_db";
$conn=mysqli_connect($sname,$uname,$password,$db_name);
if(!$conn){
    echo "Connection failed";
    exit();
}
?>
<html>
<head>    
<title>Project Link Hub</title>
<link rel="stylesheet" href="mystyle.css" type="text/css">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
      integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
   .border {
        border: var(--bs-border-widthj) var(--bs-border-style) #0e4379!important;
    }
    .colblk {
        color:white;
        font-size:20px;
    }
    .colbl {
        color:white;
    }    
    #ProjectDesc::placeholder, #ProjectTitle::placeholder, #ProjectTech::placeholder, #ProjectOutcome::placeholder {
        color:white;
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
              <form action="" method="POST" class="border shadow p-3 rounded">
                  <h1 class="text-center p-3 mb-5 colbl" style="background-color: #555; padding: 10px; border-radius: 5px; font-family: 'Arial', sans-serif; font-size: 24px; text-transform: uppercase; letter-spacing: 2px;">Suggest a Project Idea</h1>

            <div class="mb-3 m-4">
                <label for="ProjectTitle" class="form-label colblk"><b>Title</b></label>
                <input type="text" class="form-control" name="ProjectTitle" id="ProjectTitle" placeholder="Enter Project Title" style="color:white;background-color:rgb(34, 34, 31);">
            </div>
            <div class="mb-3 m-4">
                <label for="ProjectDesc" class="form-label colblk"><b>Description</b></label> <br>
                <textarea name="ProjectDesc" id="ProjectDesc" cols="60" rows="10" placeholder="Enter project description" style="color:white;background-color:rgb(34, 34, 31);"></textarea>
            </div>
            <div class="mb-3 m-4">
                <label for="ProjectTech" class="form-label colblk"><b>Required Technology</b></label>
                <input type="text" class="form-control" name="ProjectTech" id="ProjectTech" placeholder="Enter Project Technology" style="color:white;background-color:rgb(34, 34, 31);">
            </div>
            <div class="mb-3 m-4">
                <label for="ProjectOutcome" class="form-label colblk"><b>Project Outcome</b></label>
                <input type="text" class="form-control" name="ProjectOutcome" id="ProjectOutcome" placeholder="Enter Project Outcome" style="color:white;background-color:rgb(34, 34, 31);">
            </div>
            <div class="mb-3 m-4">
                <label for="ProjectSDG" class="form-label colblk"><b>Select SDG</b></label> <br>
                <select class="form-select" name="sdg" required>
                    <option id="sdg" value="GOAL 1: No Poverty">GOAL 1: No Poverty</option>
                    <option id="sdg" value="GOAL 2: Zero Hunger">GOAL 2: Zero Hunger</option>
                    <option id="sdg" value="GOAL 3: Good Health and Well-Being">GOAL 3: Good Health and Well-Being</option> 
                    <option id="sdg" value="GOAL 4: Quality Education">GOAL 4: Quality Education</option> 
                    <option id="sdg" value="GOAL 5: Gender Equality">GOAL 5: Gender Equality</option> 
                    <option id="sdg" value="GOAL 6: Clean Water and Sanitation">GOAL 6: Clean Water and Sanitation</option> 
                    <option id="sdg" value="GOAL 7: Affordable and Clean Energy">GOAL 7: Affordable and Clean Energy</option> 
                    <option id="sdg" value="GOAL 8: Decent Work and Economic Growth">GOAL 8: Decent Work and Economic Growth</option> 
                    <option id="sdg" value="GOAL 9: Industry, Innovation and Infrastructure">GOAL 9: Industry, Innovation and Infrastructure</option> 
                    <option id="sdg" value="GOAL 10: Reduced Inequalities">GOAL 10: Reduced Inequalities</option> 
                    <option id="sdg" value="GOAL 11: Sustainable Cities and Communities">GOAL 11: Sustainable Cities and Communities</option> 
                    <option id="sdg" value="GOAL 12: Responsible Consumption and Production">GOAL 12: Responsible Consumption and Production</option> 
                    <option id="sdg" value="GOAL 13: Climate Action">GOAL 13: Climate Action</option> 
                    <option id="sdg" value="GOAL 14: Life Below Water">GOAL 14: Life Below Water</option> 
                    <option id="sdg" value="GOAL 15: Life On Land">GOAL 15: Life On Land</option> 
                    <option id="sdg" value="GOAL 16: Peace, Justice and Strong Institutions">GOAL 16: Peace, Justice and Strong Institutions</option> 
                    <option id="sdg" value="GOAL 17: Partnerships for the Goals">GOAL 17: Partnerships for the Goals</option>
                </select>
            </div>
            <div class="mb-3 m-4">
                <label for="ProjectFAC" class="form-label colblk"><b>Select faculty</b></label> <br>
                <select class="form-select" name="fac" id="fac">
                    <?php
                    $sql = "SELECT * FROM users WHERE role = 'faculty'";
                    $result = mysqli_query($conn, $sql);
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            echo "<option value='".$row['username']."'>".$row['name']."</option>";
                        }
                    } else {
                        echo "<option value=''>No faculty available</option>";
                    }
                    ?>
            </select>
            </div>
            <div class="row justify-content-center">
                <input style="width: 90%; border-radius: 20px;" class="btn btn-success m-4" name="ADD" type="submit" value="SUBMIT">
                <input style="width: 90%; border-radius: 20px;" class="btn btn-danger" type="RESET" value="RESET">
            </div>
        </form>
    </div>
</div>
<?php


if(isset($_POST['ADD'])) {
    $ProjectTitle=$_POST['ProjectTitle'];  
    $ProjectDesc=$_POST['ProjectDesc'];
    $SDG=$_POST['sdg'];
    $FAC=$_POST['fac']; 
    $ProjectTech=$_POST['ProjectTech'];
    $ProjectOutcome=$_POST['ProjectOutcome']; // Get the project outcome from the form

    if(empty($ProjectTitle)) {
        echo "Title is required";
    } else if(empty($ProjectDesc)) {
        echo "Project Description is Required";    
    } else {
        $sname=$_SESSION['name'];
        $sql = "INSERT INTO suggestion (Sname, ProjectTitle, ProjectDesc, ProjectTech, SDG, fid, Time, ProjectOutcome) 
                VALUES ('$sname', '$ProjectTitle', '$ProjectDesc', '$ProjectTech', '$SDG', '$FAC', now(), '$ProjectOutcome')";
        if(mysqli_query($conn,$sql)) {
            echo '<script>
                document.getElementById("popupMessage").innerHTML = "Your suggestions have been well noted!  Thank you";
                document.getElementById("myModal").style.display = "block";
            </script>';
        } else {
            echo "Something went wrong! please try again later";
            echo mysqli_error($conn);
        }
    }
}
?>
</body>
</html>