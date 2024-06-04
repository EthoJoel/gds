<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Ticket</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        .form-group input[type="date"]
        {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .background-container {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('../image/bgpic.jpeg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            filter: blur(5px); /* Add blur effect to the background image */
            z-index: -1; /* Ensure the background image stays behind other content */
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .form-group input[type="submit"] {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group input[type="submit"]:hover {
            background-color: #0056b3;
        }

           /* Styling for select dropdown */
        select {
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            appearance: none; /* Remove default appearance */
            -webkit-appearance: none; /* Remove default appearance for Safari */
            -moz-appearance: none; /* Remove default appearance for Firefox */
            background-image: url('data:image/svg+xml;utf8,<svg fill="#000000" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24px" height="24px"><path d="M7 10l5 5 5-5H7z"/><path d="M0 0h24v24H0z" fill="none"/></svg>'); /* Custom arrow icon */
            background-repeat: no-repeat;
            background-position: right 8px center;
        }

        /* Styling for select dropdown when clicked */
        select:focus {
            outline: none;
            border-color: #4CAF50; /* Change border color when focused */
        }

        /* Styling for options in the dropdown */
        select option {
            color: #333; /* Text color */
            background-color: #fff; /* Background color */
            width: 100%;
            padding: 8px;
            margin: 6px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
            appearance: none; /* Remove default appearance */
            -webkit-appearance: none; /* Remove default appearance for Safari */
            -moz-appearance: none;
        }

        .close-button {
            background-color: #f44336;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .close-button:hover {
            background-color: #da190b;
        }
    </style>

</head>

<body>

    <!-- Background image container -->
    <div class="background-container"></div>

    <div class="container">
        <h2 align="center">Add Ticket</h2>
        <div id="error" align="center" style="color:red;"></div>

        <form method="POST">

            <div class="form-group">
                <label for="driver">Student:</label>
                <select id="student" name="student" size="1" required>
                    <option value="" disabled selected>Add Student</option>
                    <?php
                        // Establish connection
                        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

                        // Check connection
                        if (!$conn) {
                            echo "<option value=''>Error: Unable to connect to database</option>";
                        } else {
                            // Fetch Status from the database
                            $sql = "SELECT std_Reference,First_Name, Surname FROM tbl_students";
                            $result = mysqli_query($conn, $sql);

                            $id=$_GET["id"];

                            // Check if any records were returned
                            if (mysqli_num_rows($result) > 0) {
                                // Populate dropdown options
                                while($row = mysqli_fetch_assoc($result)) 
                                {
                                        echo '<option value="' . $row['std_Reference'] . '">' . $row['First_Name'] .' ' . $row['Surname']. '</option>';
                                }
                            } 
                            else 
                            {
                                echo "<option value=''>No Students found</option>";
                            }
                        }

                        // Close connection
                        mysqli_close($conn);
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="surname">Complaint:</label>
                <textarea id="com" name="com" rows='10' cols="80" required></textarea>
            </div>

            <div class="form-group">
                <label for="driver">Instructor:</label>
                <select id="instructor" name="instructor" size="1" required>
                    <option value="" disabled selected>Add Instructor</option>
                    <?php
                        // Establish connection
                        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

                        // Check connection
                        if (!$conn) {
                            echo "<option value=''>Error: Unable to connect to database</option>";
                        } else {
                            // Fetch instructors from the database
                            $sql = "SELECT instRef,First_Name, Surname FROM tbl_instructors";
                            $result = mysqli_query($conn, $sql);

                            // Check if any records were returned
                            if (mysqli_num_rows($result) > 0) {
                                // Populate dropdown options
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['instRef'] . '">' . $row['First_Name'] .' ' . $row['Surname']. '</option>';
                                }
                            } else {
                                echo "<option value=''>No instructor found</option>";
                            }
                        }

                        // Close connection
                        mysqli_close($conn);
                    ?>
                </select>
            </div>
            
            <div class="form-group">
                <label for="driver">Status:</label>
                <select id="status" name="status" size="1" required>
                    <option value="" disabled selected>Add Ticket Status</option>
                    <option value="Unread">Unread</option>
                    <option value="Processing">Processing</option>
                    <option value="Read">Read</option>
                    
                </select>
            </div>
            
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" required>
                
            </div>
            
            <div class="form-group">
                <input type="submit" name="submit" value="Insert">
                <button type='button' id='close' name='close' class='action-button close-button' onclick="closePopup()">Cancel</button>;
                   
                </div>
        </form>
    </div>

<script>

    // Function to close the popup
    function closePopup() {

        <?php
            $id2 = $_GET["id2"];
            $type = $_GET["type"];

            echo "window.location.replace('ticketspage.php?id2=$id2&type=$type');"
        ?>
    }

</script>

<?php
    if (isset($_POST['submit'])) { // Corrected button name
        add();
    }

    function add() {
        // Connect to your database
        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

        // Check connection
        if (!$conn) {
            echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
            return; // Exit function if connection fails
        }
        
        // Get form data
        $std = mysqli_real_escape_string($conn, $_POST['student']); // Sanitize input to prevent SQL injection
        $com = mysqli_real_escape_string($conn, $_POST['com']); // Sanitize input to prevent SQL injection
        $instr = mysqli_real_escape_string($conn, $_POST['instructor']); // Sanitize input to prevent SQL injection
        $status = mysqli_real_escape_string($conn, $_POST['status']); // Sanitize input to prevent SQL injection
        $date = mysqli_real_escape_string($conn, $_POST['date']); // Sanitize input to prevent SQL injection

        // Prepare SQL statement to insert the record
        $sql = "INSERT INTO `tbl_tickets`(`Student`, `Complaint`, `Instructor`, `Status`, `Date`) 
                VALUES ('$std','$com','$instr','$status','$date')";

        if ($std == "" || $com == "" || $instr == "" || $status == "" || $date == "") {
            echo "<script>document.getElementById('error').innerText = 'Kindly fill in all fields' ;</script>";
        } else {
            // Execute the SQL statement
            if (mysqli_query($conn, $sql)) {
                echo "<script> alert('Insert successful'); </script>";

                $id2 = $_GET["id2"];
                $type = $_GET["type"];
                echo "<script> window.location.replace('ticketspage.php?id2=$id2&type=$type');</script>";
                
            } else {
                echo "<script>document.getElementById('error').innerText = 'Something went wrong ... insert failed' ;</script>";
            }
        }

        // Close the database connection
        mysqli_close($conn);
    }
?>


</body>

</html>

