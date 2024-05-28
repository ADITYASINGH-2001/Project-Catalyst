<?php
session_start();
#include once (db_conn.php);
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
error_log("Attempting to include Exception.php");

require 'C:\xampp\htdocs\GA02new\php\vendor\phpmailer\phpmailer\src\Exception.php';

error_log("Attempting to include PHPMailer.php");
require 'C:\xampp\htdocs\GA02new\php\vendor\PHPMailer\PHPMailer\src\PHPMailer.php';
require 'C:\xampp\htdocs\GA02new\php\vendor\phpmailer\phpmailer\src\SMTP.php';
?>
<!DOCTYPE html> 
<html> 
<head> 
    <title>Send Notification</title> 
        <link rel="stylesheet" href="mystyle.css" type="text/css">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head> 
<body> 
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
    <p id="popupMessage">Sorry! Something went wrong</p>
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
<div class="container d-flex justify-content-center 
    align-items-center"
    style="min-height:100vh; color:white">
    <div style="box-shadow: 0 0 10px 2px  rgba(255, 255, 255, 0.5);">
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <h1 class="text-center p-3 mb-5 colbl">Send Notification</h1>
    <div class="mb-3 m-4">
        <label for="receiver" class="form-label colblk">Send to</label> <br>
        <select name="receiver" id="receiver" class="form-control" style="color:white;background-color:rgb(34, 34, 31);">
            <option value="all">All Students</option>
            <option value="specific">Specific Student</option>
            <option value="non_working">Non-Working Students</option>
        </select>
        <div id="specific_student" style="display:none;">
            <label for="receiver_id" class="form-label colblk">Receiver ID</label>
            <input type="text" name="receiver_id" style="color:white;background-color:rgb(34, 34, 31);" class="form-control" id="receiver_id">
        </div>
    </div>
    <div class="mb-3 m-4">
        <label for="message" class="form-label colblk">Message</label>
        <textarea name="message" class="form-control" style="color:white;background-color:rgb(34, 34, 31);" id="message" required></textarea>
    </div>
    <input class="btn btn-success m-4" type="submit" value="Notify">
</form>
<script>
    // Show/hide specific student field based on selected option
    document.getElementById('receiver').addEventListener('change', function() {
        if (this.value === 'specific') {
            document.getElementById('specific_student').style.display = 'block';
        } else {
            document.getElementById('specific_student').style.display = 'none';
        }
    });
</script>

</div>
<?php

include_once("db_conn.php");

$fid = $_SESSION['username'];


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = $_POST['message'];

    if ($_POST['receiver'] == 'all') {
   
        $student_ids_query = "SELECT UserName FROM student";
    } elseif ($_POST['receiver'] == 'specific') {
   
        $receiver_id = $_POST['receiver_id']; // Assuming this is the student's ID
   
        $insert_query = "INSERT INTO notifications (fid, sid, message, time) 
                         VALUES ('$fid', '$receiver_id', '$message', NOW())";
        mysqli_query($conn, $insert_query);
        echo '<script>
            document.getElementById("popupMessage").innerHTML = "Your notification has been sent successfully!";
            document.getElementById("myModal").style.display = "block";
        </script>';
        exit(); // Stop further execution
    } elseif ($_POST['receiver'] == 'non_working') {
        // Fetch non-working student IDs (assuming pid is NULL)
        $student_ids_query = "SELECT UserName,mailid FROM student WHERE pid IS NOT NULL";
    }

    if (isset($student_ids_query)) {
        $result = mysqli_query($conn, $student_ids_query);
        while ($row = mysqli_fetch_assoc($result)) {
            $receiver_id = $row['UserName'];
        
            $insert_query = "INSERT INTO notifications (fid, sid, message, time) 
                             VALUES ('$fid', '$receiver_id', '$message', NOW())";
            mysqli_query($conn, $insert_query);
            
            $email=$row['mailid'];
        
            $subject= 'Notification by Admin';
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'as2842558@gmail.com'; //host email 
            $mail->Password = 'dupx oisg swmo yrgf'; // app password of your host email
            $mail->Port = 465;
            $mail->SMTPSecure = 'ssl';
            $mail->isHTML(true);
            $mail->setFrom('as2842558@gmail.com', 'Project Catalyst');//Sender's Email & Name
            $name="Name";
            $mail->addAddress($email,$name); //Receiver's Email and Name
            $mail->Subject = ("$subject");
            $mail->Body = $message;
            $mail->send();

          
        }
        echo '<script>
            document.getElementById("popupMessage").innerHTML = "Your notification has been sent successfully!";
            document.getElementById("myModal").style.display = "block";
        </script>';
        exit(); // Stop further execution
    }
}
?>

</body> 
</html>
