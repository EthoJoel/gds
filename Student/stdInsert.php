<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Student</title>
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
            
            <h2>Add Student</h2>
            <div id="error" align="center" style="color:red;"></div>
            <form method="POST">
                <!-- Input fields for student data -->
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="txtname" name="txtname" required><br><br>
                </div>

                <div class="form-group">
                    <label for="surname">Surname:</label>
                    <input type="text" id="txtsurname" name="txtsurname" required><br><br>
                </div>

                <div class="form-group">
                    <label for="id">ID:</label>
                    <input type="text" id="txtid" name="txtid" placeholder="optional" maxlength="13" minlength="13" pattern="[0-9]{13}"><br><br>
                <div class="form-group">

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" id="txtphone" name="txtphone" maxlength="10" minlength="10" pattern="[0-9]{10}" required><br><br>
                <div class="form-group">

                <div class="form-group">
                    <label for="driver">Instructor:</label>
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
                                $type=$_GET["type"];

                                if($type=="Instructor")//if this page is logged in by an instructor, excute this block
                                {
                                    $sql = "SELECT InstRef,First_Name, Surname FROM tbl_instructors WHERE InstRef = $id2";
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
                    <label for="status">Status:</label>
                    <select id="txtstatus" name="txtstatus" size="1" required>
                        <!-- Placeholder option -->
                        <option value="" disabled selected>Select status</option>
                        <!-- Other options -->
                        <option value="Active">Active</option>
                        <option value="Passed">Passed</option>
                    </select><br><br>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="txtaddress" name="txtaddress" required><br><br>
              </div>

              <div class="form-group">
                <input type="submit" id="btnsubmit" name="btnsubmit" class="action-button">
                <button type="button" id="close" name="close" class="action-button close-button" onclick="closePopup()">Cancel</button>
              </div>
            </form>
        </div>
    </div>

    <script>

        // Function to exit this page
        function closePopup() {
            <?php 
                $type = $_GET["type"]; 
                $id2=$_GET["id2"];

                echo " window.location.replace('studentpage.php?id2=$id2&type=$type'); ";
                
            ?>
            
        }

        // Function to handle dropdown click
        document.getElementById("txtstatus").addEventListener("click", function() {
            // Show the default option when the dropdown is clicked
            this.firstElementChild.disabled = true;
            this.firstElementChild.selected = false;
        });
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
                echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
            }

            $name = $_POST["txtname"];
            $surname = $_POST["txtsurname"];
            $id = $_POST["txtid"];
            $phone = $_POST["txtphone"];
            $staff = $_POST["txtinst"];
            $status = $_POST["txtstatus"];
            $address = $_POST["txtaddress"];

            // No need to specify std_reference since it's auto incremented
            $sql = "INSERT INTO tbl_students (`First_Name`, `Surname`, `ID`, `Phone`, `Instructor`, `Status`, `Address`) VALUES ('$name', '$surname', '$id', '$phone', '$staff', '$status', '$address')";
            $id2 = $_GET["id2"];
            $type = $_GET["type"];

            if (mysqli_query($conn, $sql)) {

                echo "<script> alert('New record created successfully'); </script>";
                echo "<script>window.location.replace('studentpage.php?id2=$id2&type=$type'); </script>";   
            } 
            else {
                echo "<script>document.getElementById('error').innerText = 'Something went wrong' ;</script>";
            }

            // Close connection
            mysqli_close($conn);
        }
    ?>
    
</body>

</html>
