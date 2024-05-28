
<?php
session_start();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications</title>
    <link rel="stylesheet" href="mystyle.css" type="text/css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous">
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

        .notification {
            margin: 10px 0;
            padding: 10px;
            color: black;
            border-radius: 5px;
            background-color: #f0f0f0;
        }

        .unread {
            background-color: grey; /* Light grey for unread notifications */
        }

        /* Modal styles */
        .modal1 {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 9999; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0, 0, 0); /* Fallback color */
            background-color: rgba(0, 0, 0, 0.4); /* Black w/ opacity */
            padding-top: 60px;
        }

        /* Modal content */
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto; /* 5% from the top, centered */
            padding: 20px;
            border: 1px solid #888;
            width: 80%; /* Could be more or less, depending on screen size */
            border-radius: 10px;
        }

        /* Close button */
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
</head>

<body>
    <div class="background-container"> </div>
    <div class="content-container">
        <input type="checkbox" id="menu-toggle" checked>
        <div class="menu dflex">
            <div id="logoCSS3" class="text-center">
                <i class="fa fa-css3"></i>
            </div>
            <div class="elements-container dflex">
                <a class="element" href="myproject.php">
                    <i class="fa fa-money"></i> Project Dashboard
                </a>
                <a class="element" href="Dashboard.php">
                    <i class="fa fa-money"></i> Project Ideas
                </a>
                <a class="element" href="my_request.php">
                    <i class="fa fa-money"></i> --->My Requests
                </a>
                <a class="element" href="suggest.php">
                    <i class="fa fa-gavel"></i> Give Suggestions
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
                <p style=color:black  id="popupMessage">Sorry! The Project is Unavailable</p>
            </div>
        </div>
        <script>
          
        function openModal(message) {
          
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "update_notification_status.php", true);
                xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Modal will be opened regardless of the success of the AJAX request
                        document.getElementById("popupMessage").innerHTML = message;
                        document.getElementById("myModal").style.display = "block";
                    }
                };
                xhr.send("message=" + encodeURIComponent(message));
        }
    </script>
           
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
        <div class="container mt-5">
            <h1>Notifications</h1>
            <?php
            

            // Check if the user is logged in
            if (!isset($_SESSION['id'])) {
                // Redirect to the login page if not logged in
                header("Location: login.php");
                exit();
            }

            // Include database connection
            include_once("db_conn.php");

            // Fetch notifications for the logged-in user
            $user_id = $_SESSION['username'];
            $sql = "SELECT * FROM notifications WHERE sid = '$user_id' ORDER BY time DESC"; // Assuming time is the column name storing the timestamp
            $result = $conn->query($sql);

            // Check if there are notifications
            if ($result->num_rows > 0) {
                // Output notifications
                while ($row = $result->fetch_assoc()) {
                    // Check if the notification is unread
                    $notification_class = ($row['status'] == 0) ? 'unread' : 'notification';

                    // Output the notification content with appropriate background color
                    echo "<div  class='$notification_class' onclick=\"openModal('" . $row['message'] . "')\">";
                    echo "<p> " . $row['message'] . "</p>";
                    echo "</div>";
                }
            } else {
                echo "<p>No new notifications</p>";
            }

            // Close the database connection
            $conn->close();
            ?>
        </div>
    </div>
</body>

</html>
