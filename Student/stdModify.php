<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Modify</title>
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
        $ref = $_GET['ref'];
        $name = $_GET['name'];
        $surname = $_GET['surname'];
        $id = $_GET['id'];
        $phone = $_GET['phone'];
        $officer = $_GET['officer'];
        $status = $_GET['status'];
        $address = $_GET['address'];

        $id2 = $_GET["id2"];
      
    ?>

    <div class="container">
        <h2 align="center">Modify Student Details</h2>
        <div id="error" align="center" style="color:red;"></div>
        <form method="POST">
            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" placeholder="<?php echo $name; ?>">
            </div>
            <div class="form-group">
                <label for="surname">Surname:</label>
                <input type="text" id="surname" name="surname" placeholder="<?php echo $surname; ?>">
            </div>
            <div class="form-group">
                <label for="id">ID:</label>
                <input type="text" id="id" name="id" placeholder="<?php echo $id; ?>" maxlength="13" minlength="13" pattern="[0-9]{13}">
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="text" id="phone" name="phone" placeholder="<?php echo $phone; ?>" maxlength="10" minlength="10" pattern="[0-9]{10}">
            </div>

            <div class="form-group">
                <label for="driver">Instructor:</label>
                <select id="officer" name="officer" size="1">
                    <option value="" disabled selected><?php echo $officer; ?></option>
                    <?php
                        // Establish connection
                        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

                        // Check connection
                        if (!$conn) {
                            echo "<option value=''>Error: Unable to connect to database</option>";
                        } else {
                            // Fetch drivers from the database

                            $id2=$_GET["id2"];
                            $type=$_GET["type"];

                            if($type=="Instructor")//if this page is logged in by an instructor, excute this block
                            {
                                $sql = "SELECT InstRef,First_Name, Surname FROM tbl_instructors WHERE InstRef = $id2";
                            }
                            else
                            {
                                $sql = "SELECT * FROM tbl_instructors";
                            }

                            $result = mysqli_query($conn, $sql);

                            // Check if any records were returned
                            if (mysqli_num_rows($result) > 0) {
                                // Populate dropdown options
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['InstRef'] . '">' . $row['First_Name'].' '. $row['Surname'] . '</option>';
                                }
                            } else {
                                echo "<option value=''>No Instructors found</option>";
                            }
                        }

                        // Close connection
                        mysqli_close($conn);
                    ?>
                </select>
            </div>

            <div class="form-group">
            <label for="status">Status:</label>
                    <select id="txtstatus" name="txtstatus" size="1" >
                        <!-- Placeholder option -->
                        <option value="" disabled selected>Select status</option>
                        <!-- Other options -->
                        <option value="Active" >Active</option>
                        <option value="Passed" >Passed</option>
                    </select><br><br>
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" placeholder="<?php echo $address; ?>">
            </div>
            <div class="form-group">
                <input type="submit" name="submit" value="Update">
                <input type="submit" name="delete" value="Delete">
                <button type="button" id="close" name="close" class="action-button close-button" onclick="closePopup()">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        // Function to exit this page
        function closePopup() {
            
            <?php
                $id2=$_GET["id2"];
                $type=$_GET["type"];

                if($type=="Instructor")
                {
                    echo "window.location.replace('studentpage.php?id2=$id2&type=$type');";
                }
                else
                {
                    echo "window.location.replace('studentpage.php?id2=$id2&type=$type');";
                }    
            ?>
        }
    </script>


    <?php
   
        if (isset($_POST["delete"]))
        {
            delete();
        }

        //Function to delete the record 
        function delete()
        {
            // Connect to your database
            $conn = mysqli_connect("localhost", "root", "", "dbdrive");
        
            // Check connection
            if (!$conn) {
                echo "<script>document.getElementById('error').innerText = 'Conenction Failed' ;</script>";
            }
            
            $ref = $_GET['ref'];

            // Prepare SQL statement to update the record
            $sql = "DELETE FROM tbl_students WHERE std_reference ='$ref'";
        
                // Execute the SQL statement
                if (mysqli_query($conn, $sql)) {
                    echo "alert('Delete successful') </script>;";
                    
                    $id2=$_GET["id2"];
                    $type=$_GET["type"];

                    echo "window.location.replace('studentpage.php?id2=$id2&type=$type');";
                    
                } else {
                    echo "<script>document.getElementById('error').innerText = 'Deletion Failed' ;</script>";
                }
            
                // Close the database connection
                mysqli_close($conn);
            

        }//end of delete function

        
        // Function to update the record in the database
        function updateRecord($ref, $name, $surname, $id, $phone, $officer, $status, $address) {
            // Connect to your database
            $conn = mysqli_connect("localhost", "root", "", "dbdrive");
        
            // Check connection
            if (!$conn) {
                echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
            }
        
            // Prepare SQL statement to update the record
            $sql = "UPDATE tbl_students SET ";
        
            // Append fields to update only if they are not empty
            if (!empty($name)) {
                $sql .= "First_Name='$name', ";
            }
            if (!empty($surname)) {
                $sql .= "Surname='$surname', ";
            }
            if (!empty($id)) {
                $sql .= "ID='$id', ";
            }
            if (!empty($phone)) {
                $sql .= "Phone='$phone', ";
            }
            if (!empty($officer)) {
                $sql .= "Instructor='$officer', ";
            }
            if (!empty($status)) {
                $sql .= "Status='$status', ";
            }
            if (!empty($address)) {
                $sql .= "Address='$address', ";
            }
        
            // Remove trailing comma and space
            $sql = rtrim($sql, ", ");
        
            // Add WHERE clause
            $sql .= " WHERE std_Reference='$ref'";
        
            if( $name =="" && $surname =="" && $id=="" && $officer=="" && $phone=="" && $status=="" && $address ==""  )
            {
                echo "<script>document.getElementById('error').innerText = 'Kindly fill in atleast one textbox' ;</script>";
            }
            else
            {

                // Execute the SQL statement
                if (mysqli_query($conn, $sql)) {
                    echo "<script> alert('Update successful'); </script>" ;
                    
                    $type=$_GET["type"];
                    $id2=$_GET["id2"];

                    echo "<script> window.location.replace('studentpage.php?id2=$id2&type=$type'); </script> ";
                    
                } 
                else {
                    echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
                }//end of else

            }

            // Close the database connection
            mysqli_close($conn);

        }// end of update
        
            // Check if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                // Get form data
                $ref = $_GET['ref']; // Assuming you're passing 'ref' via GET method
                $name = $_POST['name'];
                $surname = $_POST['surname'];
                $id = $_POST['id'];
                $phone = $_POST['phone'];
                $officer = $_POST['officer'];
                $status = $_POST['txtstatus'];
                $address = $_POST['address'];
            
                // Call the function to update the record
                updateRecord($ref, $name, $surname, $id, $phone, $officer, $status, $address);
            }
   
    ?>

</body>

</html>
