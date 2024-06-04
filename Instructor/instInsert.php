<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Instructor</title>
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
            <h2>Add Instructor</h2>
            <p id="error" style="color:red;" align="center"></p>
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
                    <input type="text" id="txtid" placeholder="optional" name="txtid" maxlength="13" minlength="13" pattern="[0-9]{13}"><br><br>
                </div class="form-group">

                <div class="form-group">
                    <label for="phone">Phone:</label>
                    <input type="text" id="txtphone" name="txtphone" maxlength="10" minlength="10" pattern="[0-9]{10}" required><br><br>
                </div>

                <div class="form-group">
                    <label for="address">Address:</label>
                    <input type="text" id="txtaddress" name="txtaddress" required><br><br>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="text" id="txtPass" name="txtPass" required><br><br>
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
                $id2=$_GET["id2"];
                $type=$_GET["type"];

                echo "window.location.replace('instructorpage.php?id2=$id2&type=$type'');";
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
        return;
    }

    $name = $_POST["txtname"];
    $surname = $_POST["txtsurname"];
    $id = $_POST["txtid"];
    $phone = $_POST["txtphone"];
    $address = $_POST["txtaddress"];
    $pass = $_POST["txtPass"];

    $id2 = $_GET["id2"];
    $type = $_GET["type"];

    // Sanitize input data
    $name = mysqli_real_escape_string($conn, $name);
    $surname = mysqli_real_escape_string($conn, $surname);
    $id = mysqli_real_escape_string($conn, $id);
    $phone = mysqli_real_escape_string($conn, $phone);
    $address = mysqli_real_escape_string($conn, $address);
    $pass = mysqli_real_escape_string($conn, $pass);

    // Insert into tbl_instructors
    $sql = "INSERT INTO tbl_instructors (First_Name, Surname, ID, Phone, Address, Password) VALUES ('$name', '$surname', '$id', '$phone', '$address', '$pass')";
    
    if (mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn);

        // Select the inserted instructor's data
        $sql2 = "SELECT InstRef, First_Name, Surname, Phone, Password FROM tbl_instructors WHERE InstRef = $last_id";
        $result = mysqli_query($conn, $sql2);

        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
            $instRef = $row['InstRef'];
            $firstName = $row['First_Name'];
            $surname = $row['Surname'];
            $phone = $row['Phone'];
            $password = $row['Password'];
            $userName = $firstName . " " . $surname;

            // Insert into tbl_users
            $sql3 = "INSERT INTO tbl_users (User_Type_ID, User_Name, Phone, User_Type, Password) VALUES ($instRef, '$userName', '$phone', 'Instructor', '$password')";
            
            if (mysqli_query($conn, $sql3)) {
                echo "<script> alert('New record created successfully'); </script>";
                echo "<script>window.location.replace('instructorpage.php?id2=$id2&type=$type'); </script>";
            } else {
                echo "<script>document.getElementById('error').innerText = 'Something went wrong ... insert into tbl_users failed';</script>";
            }
        } else {
            echo "<script>document.getElementById('error').innerText = 'Something went wrong ... select from tbl_instructors failed';</script>";
        }
    } else {
        echo "<script>document.getElementById('error').innerText = 'Something went wrong ... insert into tbl_instructors failed';</script>";
    }

    // Close connection
    mysqli_close($conn);
}

    
    ?>
    
</body>

</html>
