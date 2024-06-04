<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Vehicle</title>
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

<body id="body">

    <!-- Background image container -->
    <div class="background-container"></div>

    <!-- Popup container -->
    <div class="container">
        <!-- Popup content -->
        <div class="insert-content">
            <h2>Add Vehicle</h2>
            <form method="POST">
                <!-- Input fields for student data -->
                <div class="form-group">
                    <label for="name">Brand:</label>
                    <input type="text" id="txtbrand" name="txtbrand" required><br><br>
                </div>

                <div class="form-group">
                    <label for="surname">Registration Number:</label>
                    <input type="text" id="txtreg" name="txtreg" required><br><br>
                </div>

                <div class="form-group">
                    <label for="id">VIN:</label>
                    <input type="text" id="txtvin" name="txtvin" placeholder="Optional"><br><br>
                </div class="form-group">

                <div class="form-group">
                    <label for="phone">Color:</label>
                    <input type="text" id="txtcolor" name="txtcolor" required><br><br>
                </div>

                
            <div class="form-group">
                <label for="driver">Driver:</label>
                <select id="txtdriver" name="txtdriver" size="1" required>
                    <option value="" disabled selected>Select Driver</option>
                    <?php
                        // Establish connection
                        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

                        // Check connection
                        if (!$conn) {
                            echo "<option value=''>Error: Unable to connect to database</option>";
                        } else {
                            // Fetch drivers from the database

                            $type=$_GET["type"];
                            $id2=$_GET["id2"];

                            if ($type=="Instructor")
                            {
                                $sql = "SELECT InstRef,First_Name, Surname FROM tbl_instructors WHERE InstRef= $id2";
                            }
                            else
                            {
                                $sql = "SELECT InstRef,First_Name, Surname FROM tbl_instructors";
                            }
                            
                            $result = mysqli_query($conn, $sql);

                            // Check if any records were returned
                            if (mysqli_num_rows($result) > 0) {
                                // Populate dropdown options
                                while($row = mysqli_fetch_assoc($result)) {
                                    echo '<option value="' . $row['InstRef'] . '">' . $row['First_Name']." ". $row['Surname'] . '</option>';
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
                    <label for="password">Notes</label>
                    <textarea id="txtnotes" name="txtnotes" rows='10' cols="80" placeholder="Any issues to know about the car" required></textarea><br><br>
                </div>

              <div class="form-group">
                <input type="submit" id="btnsubmit" name="btnsubmit" class="action-button">
                <button type="button" id="close" name="close" class="action-button close-button" onclick="closePopup()">Cancel</button>
              </div>
            </form>
        </div>
    </div>

    <script>
        // Function to close the popup
        function closePopup() {
            <?php
                $id2 = isset($_GET["id2"]) ? $_GET["id2"] : ''; // Ensuring $id2 is properly set
                $type = isset($_GET["type"]) ? $_GET["type"] : ''; // Ensuring $type is properly set

                if ($type=="Instructor") 
                {
                    echo "window.location.replace('vechiclepage.php?id=$id2&type=$type');";
                } 
                else 
                {
                    echo "window.location.replace('vechiclepage.php?id=$id2&type=$type');";
                }
            ?>
        }

    </script>

    <?php
        if (isset($_POST['btnsubmit'])) {
            add();
        }

        function add()
        {
            $conn = mysqli_connect("localhost", "root", "", "dbdrive");

            // Check connection
            if (!$conn) {
                echo "<script> alert('Connection failed'); </script>";
            }

            $brand = $_POST["txtbrand"];
            $reg = $_POST["txtreg"];
            $vin = $_POST["txtvin"];
            $color = $_POST["txtcolor"];
            $driver = $_POST["txtdriver"];
            $notes = $_POST["txtnotes"];

            // No need to specify std_reference since it's auto incremented
            $sql = "INSERT INTO tbl_vechicles (`Brand`, `RegNo`, `VIN`, `Color`, `Driver`, `Notes`) VALUES ('$brand', '$reg', '$vin', '$color', '$driver', '$notes')";

            if (mysqli_query($conn, $sql)) {
                echo "<script> alert('New record created successfully'); </script>";

                $id2 = $_GET["id2"];
                $type = $_GET["type"];

                echo"<script> window.location.replace('vechiclepage.php?id2=$id2&type=$type'); </script>";
               
            } else {
                echo "<script> alert('Error ... something went wrong'); </script>";
            }

            // Close connection
            mysqli_close($conn);
        }
    ?>
    
</body>

</html>
