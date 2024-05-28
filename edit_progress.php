<?php
// edit_progress_form.php

// Include your database connection code or use the existing connection if included in this file
include('db_conn.php');

// Retrieve the project ID from the URL
$id = $_GET['id'];

// Fetch project details for the given ID
$query = "SELECT * FROM student, record WHERE record.pid = student.pid AND student.id = $id";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process the form data and update the progress in the database
    $newProgress = $_POST['new_progress'];

    // Perform the update query
    $updateQuery = "UPDATE student SET progress = $newProgress WHERE id = $id";
    mysqli_query($conn, $updateQuery);
    
    if($newProgress<20){
        $updateQuery2 = "UPDATE student SET srs = null,synopsis=null,finalReport=null WHERE id = $id";
    }
    elseif($newProgress<50){
        $updateQuery2 = "UPDATE student SET srs=null,finalReport=null WHERE id = $id";
    }
    
    elseif($newProgress<90){
        $updateQuery2 = "UPDATE student SET finalReport=null WHERE id = $id";
    }
    else{
        header("Location: Deshboardf.php");
        exit();
    }
    mysqli_query($conn, $updateQuery2);
    
    header("Location: Deshboardf.php");
    exit();

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Edit Progress</title>
    <!-- Add any necessary styles or scripts here -->
    <link rel="stylesheet" href="mystyle.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <div class="container d-flex justify-content-center 
    align-items-center"
    style="min-height:100vh; color:white;">
    <div style="box-shadow: 0 0 10px 2px  rgba(255, 255, 255, 0.5);">
<form action="" method="POST" class="border shadow p-3 rounded" >
<h1 class="text-center p-3 mb-5 colbl" >Add a Project</h1>
        <h2>Edit Progress</h2>
        <form method="post" action="">
            <div class="mb-3">
                <label for="new_progress" class="form-label">New Progress:</label>
                <input type="number" class="form-control" id="new_progress" name="new_progress" min="0" max="100"
                    value="<?php echo $row['progress']; ?>" required>
            </div>
            <button type="submit" class="btn btn-primary">Save Progress</button>
        </form>
    </div>
</body>

</html>
