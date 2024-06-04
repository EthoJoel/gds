<?php
    // Established a database connection
    $conn= mysqli_connect("localhost","root","","dbdrive");

    // Fetch list of instructors from the database
    $sql_instructors = "SELECT InstRef, First_Name, Surname FROM tbl_instructors";
    $result_instructors = mysqli_query($conn, $sql_instructors);

    // Fetch list of students from the database
    $sql_students = "SELECT std_Reference, First_Name, Surname FROM tbl_students";
    $result_students = mysqli_query($conn, $sql_students);

    // Close the database connection after fetching the data
    mysqli_close($conn);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Message Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f7f7f7;
        }

        .container {
            max-width: 500px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            margin-bottom: 10px;
            font-weight: bold;
        }

        select,
        input[type="date"],
        input[type="time"],
        input[type="submit"] {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        @media only screen and (max-width: 600px) {
            .container {
                width: 90%;
            }
        }

        .back{    
        background-color: #f44336;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        font-size: 16px;
        }

        .back:hover {
        background-color: #da190b;
        }
    </style>
</head>
<body>

<button class="back" value="Back" onclick="back()">Back</button>

<script>    
    function back() {   
        <?php 
        // Retrieve and sanitize the id and type parameters
        $id = isset($_GET["id2"]) ? htmlspecialchars($_GET["id2"]) : "";
        $type = isset($_GET["type"]) ? htmlspecialchars($_GET["type"]) : "";
        
        // Redirect with id and type parameters
        echo "window.location.replace('../Login/HomePage.php?id2=$id&type=$type');";
        
        ?>
    }
</script>

    <div class="container">
        <h2>Compose Message</h2>
        <form action="send_message.php" method="post">

            <label for="instructor">Select Instructor:</label>
            <select name="instructor" id="instructor">
                <option value="" disabled selected>Select Instructor</option>
                <?php while ($row = mysqli_fetch_assoc($result_instructors)) : ?>
                    <option value="<?php echo $row['InstRef']; ?>"><?php echo $row['First_Name'] . ' ' . $row['Surname']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="student">Select Student:</label>
            <select name="student" id="student">
                <option value="" disabled selected>Select Student</option>
                <?php while ($row = mysqli_fetch_assoc($result_students)) : ?>
                    <option value="<?php echo $row['std_Reference']; ?>"><?php echo $row['First_Name'] . ' ' . $row['Surname']; ?></option>
                <?php endwhile; ?>
            </select>

            <label for="date">Select Date:</label>
            <input type="date" name="date" id="date">
            <label for="time">Select Time:</label>
            <input type="time" name="time" id="time">
            <input type="submit" value="Send Message">
        </form>
    </div>
</body>
</html>
