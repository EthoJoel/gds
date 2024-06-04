<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehicle Modify</title>
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
        $brand = $_GET['brand'];
        $reg = $_GET['reg'];
        $vin = $_GET['vin'];
        $color = $_GET['color'];
        $driver = $_GET['driver'];
        $notes = $_GET['notes'];
    ?>

    <div class="container">
        <h2 align="center">Modify Vehicle Details</h2>
        <div id="error" align="center" style="color:red;"></div>
        <form method="POST">
            <div class="form-group">
                <label for="name">Brand:</label>
                <input type="text" id="brand" name="brand" placeholder="<?php echo $brand; ?>">
            </div>

            <div class="form-group">
                <label for="surname">Registration Number:</label>
                <input type="text" id="reg" name="reg" placeholder="<?php echo $reg; ?>">
            </div>

            <div class="form-group">
                <label for="id">Vin:</label>
                <input type="text" id="vin" name="vin" 
                placeholder="<?php if(!empty($vin))
                                    {
                                        echo $vin;
                                    }else{ echo"Optional"; } ?>" >
            </div>

            <div class="form-group">
                <label for="phone">Color:</label>
                <input type="text" id="color" name="color" placeholder="<?php echo $color; ?>">
            </div>


            <div class="form-group">
                <label for="driver">Driver:</label>
                <select id="driver" name="driver" size="1" >
                    <option value="" disabled selected>
                        <?php 
                          
                            $conn = mysqli_connect("localhost", "root", "", "dbdrive");

                            // Check connection
                            if (!$conn) {
                                echo "<option value=''>Error: Unable to connect to database</option>";
                            } 
                            else {
                                $driver2= $_GET['driver'];
                                $type=$_GET["type"];

                                if($type=="Instructor")
                                {
                                    $sql = "SELECT InstRef, First_Name, Surname FROM tbl_instructors WHERE InstRef = '$driver2'";
                                }
                                else
                                {
                                    $sql = "SELECT InstRef, First_Name, Surname FROM tbl_instructors WHERE InstRef = '$driver' ";
                                }

                                $result = mysqli_query($conn, $sql);
                                if (mysqli_num_rows($result) > 0) 
                                {
                                    // Populate dropdown options
                                    while($row = mysqli_fetch_assoc($result)) 
                                    {
                                        echo $driver = $row["First_Name"]." ".$row["Surname"];
                                    }
                                }  
                                // Close connection
                                mysqli_close($conn);    
                            } 
                        
                        ?>
                    </option>
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
                <label for="password">Notes:</label>
                <textarea id="Notes" name="notes" rows='10' cols="80" placeholder="<?php echo $notes; ?>"></textarea>
            </div>
            
            <div class="form-group">
                <input type="submit" name="submit" value="Update">
                <input type="submit" name="delete" value="Delete">
                <button type="button" id="close" name="close" class="action-button close-button" onclick="closePopup()">Cancel</button>
            </div>
        </form>
    </div>

    <script>
        // Function to close the popup
        function closePopup() {
            <?php
                $id2 = isset($_GET["id2"]) ? $_GET["id2"] : ''; // Ensuring $id2 is properly set
                $type = isset($_GET["type"]) ? $_GET["type"] : ''; // Ensuring $type is properly set

                echo "window.location.replace('vechiclepage.php?id2=$id2&type=$type');";
                
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
                echo "<script> document.getElementById('error').innerText='Connection failed'; </script>";
            }
            
            $ref = $_GET['ref'];

            // Prepare SQL statement to update the record
            $sql = "DELETE FROM tbl_vechicles WHERE vecRef ='$ref'";
        
                // Execute the SQL statement
                if (mysqli_query($conn, $sql)) {
                    echo "<script> alert('Delete successful') </script>;";
                    
                    $id2=$_GET["id2"];
                    $type=$_GET["type"];

                    echo "<script> window.location.replace('vechiclepage.php?id2=$id2&type=$type'); </script>";
                    
                } else {
                    echo " <script> document.getElementById('error').innerText='Deletion failed'; </script>";
                }
            
                // Close the database connection
                mysqli_close($conn);
            

        }//end of delete function

        
        // Function to update the record in the database
        function updateRecord($ref, $brand, $reg, $vin, $color, $driver, $notes) {
            // Connect to your database
            $conn = mysqli_connect("localhost", "root", "", "dbdrive");
        
            // Check connection
            if (!$conn) {
                echo "<script> document.getElementById('error').innerText='Connection failed'; </script>";
            }
        
            // Prepare SQL statement to update the record
            $sql = "UPDATE tbl_vechicles SET ";
        
            // Append fields to update only if they are not empty
            if (!empty($brand)) {
                $sql .= "Brand='$brand', ";
            }
            if (!empty($reg)) {
                $sql .= "RegNo='$reg', ";
            }
            if (!empty($vin)) {
                $sql .= "Vin='$vin', ";
            }
            if (!empty($color)) {
                $sql .= "Color='$color', ";
            }
            if (!empty($driver)) {
                $sql .= "Driver='$driver', ";
            }
            if (!empty($notes)) {
                $sql .= "Notes='$notes', ";
            }
            // Remove trailing comma and space
            $sql = rtrim($sql, ", ");
        
            // Add WHERE clause
            $sql .= " WHERE vecRef ='$ref'";
        
            if( $brand =="" && $reg =="" && $vin=="" && $color=="" && $driver =="" && $notes ==""  )
            {
                echo"<script> document.getElementById('error').innerText='Kindly fill in atleast one textbox'; </script>";
            }
            else
            {

                // Execute the SQL statement
                if (mysqli_query($conn, $sql)) {
                    echo "<script> alert('Update successful'); </script>" ;

                    $id2 = isset($_GET["id2"]) ? $_GET["id2"] : ''; // Ensuring $id2 is properly set
                    $type = isset($_GET["type"]) ? $_GET["type"] : ''; // Ensuring $type is properly set

                    echo "<script>window.location.replace('vechiclepage.php?id2=$id2&type=$type');</script>";
                
                } 
                else {
                    echo "<script> document.getElementById('error').innerText='Connection failed'; </script>";
                }//end of else

            }

            // Close the database connection
            mysqli_close($conn);

        }// end of update
        
            // Check if form is submitted
            if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
                // Get form data
                $ref = $_GET['ref']; // Assuming you're passing 'ref' via GET method
                $brand = $_POST['brand'];
                $reg = $_POST['reg'];
                $vin = $_POST['vin'];
                $color = $_POST['color'];
                $driver = $_POST['driver'];
                $notes = $_POST['notes'];
            
                // Call the function to update the record
                updateRecord($ref, $brand, $reg, $vin, $color, $driver, $notes);
            }
   
    ?>

</body>

</html>
