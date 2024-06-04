<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Journal Entries</title>
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

        .form-group input[type="date"],
        .form-group textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

        .form-group input[type="submit"],
        .form-group input[type="button"] {
            background-color: #007bff;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .form-group input[type="submit"]:hover,
        .form-group input[type="button"]:hover {
            background-color: #0056b3;
        }
        #close-button {
            background-color: #f44336;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        #close-button:hover {
            background-color: #da190b;
        }

        #error {
            color: red;
            text-align: center;
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
        
    </style>
</head>

<body id="body">

    <!-- Background image container -->
    <div class="background-container"></div>

    <div class="container">
        <h2>Journal Entries</h2>
        <p id="error"></p>
        <form method="post">
            <div class="form-group">
                <label>Instructor:</label>
                <select id="txtinst" name="txtinst" size="1" required>
                    <option value="" disabled selected>Select Instructor</option>
                    <?php
                        // Establish connection
                        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

                        // Check connection
                        if (!$conn) {
                            echo "<option value=''>Error: Unable to connect to database</option>";
                        } else {
                            // Fetch drivers from the database
                            $id2=$_GET["id2"];

                            if(!empty($id2))
                            {
                                $sql = "SELECT InstRef,First_Name, Surname FROM tbl_instructors WHERE InstRef = $id2";
                            }
                            else
                            {
                                $sql = "SELECT InstRef,First_Name, Surname FROM tbl_instructors";
                            }
                            
                            // Check if any records were returned
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                // Populate dropdown options
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['InstRef'] . '">' . $row['First_Name'].' '. $row['Surname'] . '</option>';
                                }
                            } else {
                                echo "<option value=''>No drivers found</option>";
                            }
                        }

                        // Close connection
                        mysqli_close($conn);
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="entry_date">Date:</label>
                <input type="date" id="entry_date" name="entry_date" required>
            </div>
            <div class="form-group">
                <label for="entry_text">Journal Entry:</label>
                <textarea id="entry_text" name="entry_text" rows="4" cols="50" required></textarea>
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Submit Entry">
                <input type="submit" name="cancel" id="close-button" value="Cancel" onclick="closePopup()">
            </div>
        </form>
    </div>

    <script>

        // Function to exit this page
        function closePopup() {
            <?php 
                $type = $_GET["type"]; 
                $id2=$_GET["id2"];

                echo " window.location.replace('../Login/HomePage.php?id2=$id2&type=$type'); ";
            ?>           
        }

        function read()
        {
            <?php
                $type = $_GET["type"]; 
                $id2=$_GET["id2"];

                echo " window.location.replace('jread.php?id2=$id2&type=$type');";    
            ?>
        }
    </script>

<?php

    if(isset($_POST["submit"]))
    {
        insertJournal();
    }

    function insertJournal()
    {
        // Include database connection
        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

            // Check connection
            if (!$conn) {
                echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
            }
            else
            {
                    // Get form data
                    $id2 = $_GET['id2']; 
                    $type = $_GET['type']; 
                    $inst = $_POST["txtinst"];
                    $entry_date = $_POST['entry_date'];
                    $entry_text = $_POST['entry_text'];

                    // Insert the entry into the database
                    $sql = "INSERT INTO `journal_entries`(`instructor_id`, `entry_date`, `entry_text`) VALUES ('$inst','$entry_date','$entry_text')";
                    
                        if (mysqli_query($conn, $sql)) {

                            echo "<script> alert('New record created successfully'); </script>";   
                            echo "<script> window.location.replace('../HomePage.php?id2=$id2&type=$type'); </script>";   
                        } 
                        else {
                            echo "<script>document.getElementById('error').innerText = 'Something went wrong' ;</script>";
                        }

                        // Close connection
                        mysqli_close($conn);
            }
    }

    

?>

</body>

</html>