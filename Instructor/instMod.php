<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instructor Modify</title>
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
        $address = $_GET['address'];
        $pass = $_GET['password'];
    ?>

    <div class="container">
        <h2 align="center">Modify Instructor Details</h2>
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
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" placeholder="<?php echo $address; ?>">
            </div>

            <div class="form-group">
                <label for="password">Password:</label>
                <input type="text" id="password" name="password" placeholder="<?php echo $pass; ?>">
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
                $id2  = $_GET["id2"];
                $type = $_GET["type"];

                echo "window.location.replace('instructorpage.php?id2=$id2&type=$type');";    
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
                echo "<script> document.getElementById('error').innerText= 'Connection failed'; </script>";
            }
            
            $ref = $_GET['ref'];

            // Prepare SQL statement to update the record
            $sql = "DELETE FROM tbl_instructors WHERE InstRef ='$ref'";
            $sql2 = "DELETE FROM tbl_users WHERE User_Type_ID ='$ref'";
        
                // Execute the SQL statement
                if (mysqli_query($conn, $sql) && mysqli_query($conn, $sql2)) {
                    echo "<script> alert('Delete successful'); </script>";

                    $id2 = $_GET["id2"];
                    $type = $_GET["type"];

                    echo " <script> window.location.replace('instructorpage.php?id2=$id2&type=$type');</script>";   
                    
                } else {
                    echo " <script> document.getElementById('error').innerText =('Deletion failed'); </script>";
                }
            
                // Close the database connection
                mysqli_close($conn);
            

        }//end of delete function

        
        // Function to update the record in the database
        function updateRecord($ref, $name, $surname, $id, $phone, $address, $pass) {
            // Connect to your database
            $conn = mysqli_connect("localhost", "root", "", "dbdrive");
        
            // Check connection
            if (!$conn) {
                echo "<script> document.getElementById('error').innerText =('Connection failed'); </script>";
            }
        
            // Prepare SQL statement to update the record
            $sql = "UPDATE tbl_instructors SET ";
            $sql2 = "UPDATE tbl_users SET ";
        
            // Append fields to update only if they are not empty
            if (!empty($name)) {
                $sql .= "First_Name='$name', ";

                $sname2 =$_GET["surname"];
                $username .= $name." ".$sname2 ; 
                $sql2 .= "User_Name='$username', ";
            }
            if (!empty($surname)) {
                $sql .= "Surname='$surname', ";

                $name2 =$_GET["name"];
                $username= $name2." ".$surname ;
                $sql2 .= "User_Name='$username', ";
            }
            if (!empty($id)) {
                $sql .= "ID='$id', ";
            }
            if (!empty($phone)) {
                $sql .= "Phone='$phone', ";
                $sql2 .= "Phone='$phone', ";
            }
            if (!empty($address)) {
                $sql .= "Address='$address', ";
            }
            if (!empty($pass)) {
                $sql .= "Password='$pass', ";
                $sql2 .= "Password='$pass', ";
            }
            // Remove trailing comma and space
            $sql = rtrim($sql, ", ");
            $sql2 = rtrim($sql2, ", ");
        
            // Add WHERE clause
            $sql .= " WHERE InstRef ='$ref'";
            $sql2 .= " WHERE User_Type_ID = $ref";
        

            if( $name =="" && $surname =="" && $id=="" && $phone=="" && $address =="" && $pass ==""  )
            {
                echo"<script> document.getElementById('error').innerText =('Kindly fill in atleast one textbox'); </script>";
            }
            else
            {
                // Execute the SQL statement
                if (mysqli_query($conn, $sql) && (mysqli_query($conn, $sql2)) ) 
                {
                    echo "<script> alert('Update successful'); </script>" ;

                    $id2=$_GET["id2"];
                    $type=$_GET["type"];

                    echo "<script> window.location.replace('instructorpage.php?id2=$id2&type=$type');</script>";
                } 
                else 
                {
                    echo "<script> document.getElementById('error').innerText =('Connection failed'); </script>";
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
                $address = $_POST['address'];
                $pass = $_POST['password'];
            
                // Call the function to update the record
                updateRecord($ref, $name, $surname, $id, $phone, $address, $pass);
            }
   
    ?>

</body>

</html>
