<html>

<style>
        .form-group input[type="date"]
        {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font-size: 16px;
        }

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


<?php

    $jid = $_GET["jid"];
    $iid = $_GET["iid"];
    $date = $_GET["date"];
    $text = $_GET["text"];

    $conn = mysqli_connect("localhost", "root", "", "dbdrive");
    // Fetch instructor details
    if ($conn) {
        $sql = "SELECT * FROM tbl_instructors WHERE InstRef='$iid';";
        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $instructorName = $row["First_Name"] . " " . $row["Surname"];
            }
        }
    }

?>

<body id="body">

    <!-- Background image container -->
    <div class="background-container"></div>

<div class="container">
    <h2 align="center">Modify Journal Entries</h2>
    <div id="error" align="center" style="color:red;"></div>

    <form method="POST">
        <div class="form-group">
            <label for="name">Instructor Name:</label>
            <input type="text" id="name" name="name" placeholder="<?php echo $instructorName; ?>" readonly>
        </div>

        <div class="form-group">
            <label for="surname">Entry Date:</label>
            <input type="date" id="date" name="date" value="<?php echo $date; ?>">
        </div>

        <div class="form-group">
            <label for="phone">Text:</label>
            <input type="text" id="txtText" name="txtText" placeholder="<?php echo $text; ?>">
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
        $id2 = $_GET["id2"];
        $type = $_GET["type"];

        echo "window.location.replace('jread.php?id2=$id2&type=$type');";
        ?>
    }
</script>

<?php

    if (isset($_POST['submit'])) {
        update();
    }

    if (isset($_POST['delete'])) {
        delete();
    }

    function update()
    {
        $conn = new mysqli("localhost", "root", "", "dbdrive");

        if (!$conn) {
            echo "<script>document.getElementById('error').innerText='Connection Failed'; </script>";
        } else {
            $date = $_POST["date"];
            $text = $_POST["txtText"];
            $jid = $_GET["jid"];

            $sql = "UPDATE `journal_entries` SET ";

            if ($date) {
                $sql .= " `entry_date`='$date', ";
            }
            if ($text) {
                $sql .= " `entry_text`='$text', ";
            }

            $sql = rtrim($sql, ", ");
            $sql .= " WHERE journal_id= '$jid'";

            $id2 = $_GET["id2"];
            $type = $_GET["type"];

            if (!$text && !$date) {
                echo "<script> document.getElementById('error').innerText='Kindly fill in at least one textbox'; </script>";
            } else {
                if ($conn->query($sql) === TRUE) {
                    echo "<script> alert('Update Successful'); </script>";
                    echo "<script> window.location.replace('jread.php?id2=$id2&type=$type'); </script>";
                } else {
                    echo "<script> document.getElementById('error').innerText='Update Failed'; </script>";
                }
            }
        }
    }

    function delete()
    {
        $conn = new mysqli("localhost", "root", "", "dbdrive");

        if (!$conn) {
            echo "<script>document.getElementById('error').innerText='Connection Failed'; </script>";
        } else {
            $jid = $_GET["jid"];

            $sql = "DELETE FROM `journal_entries` WHERE journal_id='$jid'";

            if ($conn->query($sql) === TRUE) {
                echo "<script> alert('Delete Successful'); </script>";
                echo "<script> window.location.replace('jread.php?id2=$id2&type=$type'); </script>";
            } else {
                echo "<script> document.getElementById('error').innerText='Delete Failed'; </script>";
            }
        }
    }

?>

</body>

</html>
