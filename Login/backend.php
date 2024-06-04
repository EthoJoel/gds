<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="styleLogin.css">
</head>
<body>

    <!-- Background image container -->
    <div class="background-container"></div>

    <input type="image" src="../image/gds.jpg" style="width: 100px; /* Adjust the width as needed */
            height: auto; /* Automatically adjust height based on width */" >

    <h2>Login Form</h2>
    <form method="POST" id="loginForm" >
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit" name="btnsubmit" align="center">Login</button>
    </form>
    <div id="error"></div>

<?php

if (isset($_POST['btnsubmit']))
    {
        verifFunc();
    }

    function verifFunc()
    {
        // Connect to your database
        $conn = mysqli_connect("localhost", "root", "", "dbdrive");
    
        // Check connection
        if (!$conn) {
            echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
            exit(); // Exit function if connection fails
        }
    
        // Query to check user credentials
        $username = $_POST['username'];
        $password = $_POST['password'];
        $sql = "SELECT * FROM tbl_users WHERE User_Name = ? AND Password = ?";
        
        // Prepare and execute the query
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $username, $password); // Bind parameters to the query
        $stmt->execute();
        $result = $stmt->get_result();
        
        // Fetch the user row
        $user = $result->fetch_assoc();
    
        // If user exists and credentials are correct
        if ($user) {
            // Check user type and redirect accordingly
            switch ($user['User_Type']) {
                case 'Admin':
                    // Redirect to homepage with user ID and type as parameters
                    header("Location: Homepage.php?id2=" . "0". "&type=" . urlencode($user['User_Type']));
                    exit();
                case 'Instructor':
                    // Redirect to homepage with user ID and type as parameters
                    header("Location: Homepage.php?id2=" . $user['User_Type_ID'] . "&type=" . urlencode($user['User_Type']));
                    exit();
            }
        } else {
            // Redirect to login page if credentials are incorrect
            echo "<script>document.getElementById('error').innerText = 'Invalid username or password';</script>";
            exit();
        }
    }//end of function

?>


</body>
</html>
