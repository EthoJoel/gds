<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ticket Modify</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
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

    <?php
        $ticketNo = $_GET['ticketNo'];
        $std = $_GET['std'];
        $com = $_GET['complaint'];
        $instr = $_GET['instr'];
        $status = $_GET['status'];
        $date = $_GET['date'];
    ?>

    <div class="container">
        <h2 align="center">Modify Ticket Details</h2>
        <div id="error" align="center" style="color:red;"></div>
        <form method="POST">
        <div class="form-group">
                <label for="driver">Student:</label>
                <select id="student" name="student" size="1">
                    <option value="" disabled selected><?php echo $std; ?></option>
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
                <textarea id="com" name="com" rows='10' cols="80" placeholder="<?php echo $com; ?>"></textarea>
            </div>

            <div class="form-group">
                <label for="driver">Instructor:</label>
                <select id="instructor" name="instructor" size="1">
                    <option value="" disabled selected><?php echo $instr; ?></option>
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
                <select id="status" name="status" size="1">
                    <option value="" disabled selected><?php echo $status; ?></option>
                    <option value="Unread">Unread</option>
                    <option value="Processing">Processing</option>
                    <option value="Read">Read</option>
                    
                </select>
            </div>
            
            <div class="form-group">
                <label for="date">Date:</label>
                <input type="text" id="date" name="date" pattern="\d{4}-\d{2}-\d{2}" placeholder="<?php echo $date; ?>">
                
            </div>
            
            <div class="form-group">
                <input type="submit" name="submit" value="Update">
                <input type="submit" name="delete" value="Delete">
                <button type="button" id="close" name="close" class="action-button close-button" onclick="closePopup()">Cancel</button>
            </div>
        </form>
    </div>

    

    <?php
   
        if (isset($_POST["delete"]))
        {
            delete();
        }

        if(isset($_POST["submit"]))
        {
            updateRecord();
        }

        //Function to delete the record 
        function delete()
        {
            // Connect to your database
            $conn = mysqli_connect("localhost", "root", "", "dbdrive");
        
            // Check connection
            if (!$conn) {
                echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
            }
            
            $ticketNo = $_GET['ticketNo'];

            $id2= $_GET["id2"];
            $type= $_GET["type"];

            // Prepare SQL statement to update the record
            $sql = "DELETE FROM tbl_tickets WHERE ticketNo ='$ticketNo'";
        
                // Execute the SQL statement
                if (mysqli_query($conn, $sql)) {
                    echo "<script> alert('Delete successful'); </script>";
                    echo " <script> window.location.replace('ticketspage.php?id2=$id2&type=$type');</script>";
                } else {
                    echo "<script>document.getElementById('error').innerText = 'Deletion Failed' ;</script>";
                }
            
                // Close the database connection
                mysqli_close($conn);
            

        }//end of delete function

        
        // Function to update the record in the database
        function updateRecord() {
            // Connect to your database
            $conn = mysqli_connect("localhost", "root", "", "dbdrive");
        
            // Check connection
            if (!$conn) {
                echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
            }
            
            $ticketNo = $_GET['ticketNo']; // Assuming you're passing 'ticketNo' via GET method
            $std = $_POST['student'];
            $com = $_POST['com'];
            $instr = $_POST['instructor'];
            $status = $_POST['status'];
            $date = $_POST['date'];

            // Prepare SQL statement to update the record
            $sql = "UPDATE tbl_tickets SET ";
        
            // Append fields to update only if they are not empty
            if (!empty($std)) {
                $sql .= "Student='$std', ";
            }
            if (!empty($com)) {
                $sql .= "Complaint='$com', ";
            }
            if (!empty($instr)) {
                $sql .= "Instructor='$instr', ";
            }
            if (!empty($status)) {
                $sql .= "Status='$status', ";
            }
            if (!empty($date)) {
                $sql .= "Date='$date', ";
            }
            
            // Remove trailing comma and space
            $sql = rtrim($sql, ", ");
        
            // Add WHERE clause
            $sql .= " WHERE ticketNo ='$ticketNo'";
        
            if( $std =="" && $com =="" && $instr=="" && $status=="" && $date =="")
            {
                echo "<script>document.getElementById('error').innerText = 'Kindly fill in atleast one textbox' ;</script>";
            }
            else
            {
                $id2= $_GET["id2"];
                $type= $_GET["type"];
                // Execute the SQL statement
                if (mysqli_query($conn, $sql)) {
                    echo "<script> alert('Update successful'); </script>" ;
                    echo " <script> window.location.replace('ticketspage.php?id2=$id2&type=$type');</script>";
                } 
                else {
                    echo "<script>document.getElementById('error').innerText = 'Update Failed' ;</script>";
                }
            }//end of else

            // Close the database connection
            mysqli_close($conn);

        }// end of update
   
    ?>

</body>

</html>
