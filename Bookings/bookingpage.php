<?php
session_start();

// Initialize events if not already set
if (!isset($_SESSION['events'])) {
    $_SESSION['events'] = [];
}

// Retrieve user type and instructor ID from URL
$type = $_GET["type"];
$id2 = $_GET["id2"];

// Generate a dynamic pastel color for each instructor
function generatePastelColor($seed)
{
    // Use a hash function to generate a unique color code based on the seed
    $hash = md5($seed);
    $color = [
        hexdec(substr($hash, 0, 2)),
        hexdec(substr($hash, 2, 2)),
        hexdec(substr($hash, 4, 2))
    ];
    // Adjust the color to be pastel
    $color = array_map(function ($component) {
        return ($component + 255) / 2;
    }, $color);
    return 'rgb(' . implode(',', $color) . ')';
}

// Fetch distinct instructor IDs from the events and generate colors
$instructor_colors = [];
foreach ($_SESSION['events'] as $event) {
    $instructor_id = $event['instructor'];
    if (!isset($instructor_colors[$instructor_id])) {
        $instructor_colors[$instructor_id] = generatePastelColor($instructor_id);
    }
}

// Handle form submission to add booking and add booking to dbdrive
if (isset($_POST['add_booking'])) {
    $event_date = $_POST['event_date'];
    $lesson = $_POST['lesson'];

    // Add the booking for the specific date
    $_SESSION['events'][$event_date] = [
        'lesson' => $lesson,
        'instructor' => $id2 // Store the instructor ID with the booking
    ];

    // Collects the month, day, year and the booking into the database
    if (isset($event_date) && isset($lesson)) {
        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

        if ($conn) {
            $sql = "INSERT INTO `tbl_tasks`(`instructor`, `booking`, `date`) VALUES (?,?,?)";

            $stmt = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt, "iss", $id2, $lesson, $event_date);

            if (mysqli_stmt_execute($stmt)) {
                echo "<script> alert('Successful'); </script>";
            } else {
                echo "<script> alert('Unsuccessful'); </script>";
            }

            mysqli_close($conn);
        }
    }
}

// Handle deletion of events
if (isset($_POST['delete_event'])) {
    $event_date = $_POST['event_date'];
    unset($_SESSION['events'][$event_date]);

    $conn = mysqli_connect("localhost", "root", "", "dbdrive");

    if ($conn) {
        $sql = "DELETE FROM tbl_tasks WHERE date = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "s", $event_date);

        if (mysqli_stmt_execute($stmt)) {
            echo "<script> alert('Reminder deleted successfully.'); </script>";
        } else {
            echo "<script> alert('Failed to delete reminder.'); </script>";
        }

        mysqli_close($conn);
    } else {
        echo "<script> alert('Failed to connect to the database.'); </script>";
    }
}


// Determine the month and year to display
if (isset($_POST['month']) && isset($_POST['year'])) {
    $month = $_POST['month'];
    $year = $_POST['year'];
} else {
    $month = date('m');
    $year = date('Y');
}

// Adjust the month and year based on navigation
if (isset($_POST['prev_month'])) {
    $month--;
    if ($month < 1) {
        $month = 12;
        $year--;
    }
}
if (isset($_POST['next_month'])) {
    $month++;
    if ($month > 12) {
        $month = 1;
        $year++;
    }
}

// Get the current date
$current_day = date('j');
$current_month = date('m');
$current_year = date('Y');

// Find out the number of days in the month
$num_days = cal_days_in_month(CAL_GREGORIAN, $month, $year);

// Determine the day of the week the month starts on
$first_day = mktime(0, 0, 0, $month, 1, $year);
$day_of_week = date('w', $first_day);

// Days of the week
$days_of_week = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking</title>
    <style>
        .back {
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

        body {
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            align-items: center;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
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
            filter: blur(5px);
            /* Add blur effect to the background image */
            z-index: -1;
            /* Ensure the background image stays behind other content */
        }

        .container {
            width: 100%;
            max-width: 1200px;
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            padding: 20px;
            box-sizing: border-box;
        }

        .calendar-container,
        .reminder-container {
            background: #fff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin: 10px;
            padding: 20px;
            border-radius: 8px;
            box-sizing: border-box;
        }

        .calendar-container {
            flex: 1 1
            600px;
        }

        .reminder-container {
            flex: 1 1 400px;
        }

        h1,
        h2 {
            text-align: center;
            color: #333;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background: #ddd;
            padding: 10px;
            border-radius: 8px;
        }

        .day,
        .header {
            padding: 15px;
            background: #fff;
            text-align: center;
            border-radius: 4px;
        }

        .header {
            background: #f4f4f4;
            font-weight: bold;
        }

        .day.event {
            background: #ffeb3b;
        }

        .day.current {
            background: #90caf9;
        }

        form {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 20px;
        }

        input[type="text"],
        input[type="date"],
        input[type="submit"] {
            margin: 5px;
            padding: 10px 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
            max-width: 300px;
            box-sizing: border-box;
        }

        input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
            border: none;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .reminder-list {
            list-style-type: none;
            padding: 0;
        }

        .reminder-list li {
            margin: 10px 0;
            padding: 10px;
            background: #f4f4f4;
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-radius: 4px;
        }

        .reminder-list button {
            background: #ff1744;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .reminder-list button:hover {
            background: #d50000;
        }

        .navigation {
            display: flex;
            justify-content: center;
            margin-bottom: 20px;
        }

        .navigation form {
            margin: 0 10px;
        }

        .navigation input[type="submit"] {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 4px;
            cursor: pointer;
        }

        .navigation input[type="submit"]:hover {
            background: #0056b3;
        }

        <?php
        // Generate CSS rules for instructor colors
        foreach ($instructor_colors as $instructor_id => $color) {
            echo ".instructor-$instructor_id { background-color: $color; }";
        }
        ?>
    </style>
</head>

<body id="body">
    <!-- Background image container -->
    <div class="background-container"></div>

    <button class="back" value="Back" onclick="back()" align="left">Back</button>

    <script>
        function back() {
            <?php
            // Redirect with id and type parameters
            echo "window.location.replace('../Login/HomePage.php?id2=$id2&type=$type');";
            ?>
        }
    </script>

    <div class="container">
        <div class="calendar-container">
            <h1>Calendar</h1>
            <?php if ($type === "Instructor") : ?>
                <form action="" method="post">
                    <input type="date" name="event_date" required>
                    <input type="text" name="lesson" placeholder="Lesson booking" required>
                    <input type="submit" name="add_booking" value="Add booking">
                </form>
            <?php endif; ?>

            <div class="navigation">
                <form method="post" style="display:inline;">
                    <input type="hidden" name="month" value="<?= $month ?>">
                    <input type="hidden" name="year" value="<?= $year ?>">
                    <input type="submit" name="prev_month" value="&lt;" />
                </form>
                <span><?= date('F Y', strtotime("$year-$month-01")) ?></span>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="month" value="<?= $month ?>">
                    <input type="hidden" name="year" value="<?= $year ?>">
                    <input type="submit" name="next_month" value="&gt;" />
                </form>
            </div>

            <div class="calendar">
                <?php
                // Display the headers
                foreach ($days_of_week as $day) {
                    echo '<div class="header">' . $day . '</div>';
                }

                // Add empty cells for days before the first of the month
                for ($i = 0; $i < $day_of_week; $i++) {
                    echo '<div class="day"></div>';
                }

                // Display the days of the month
                for ($day = 1; $day <= $num_days; $day++) {
                    $date_str = "$year-$month-" . str_pad($day, 2, '0', STR_PAD_LEFT);
                    $class = 'day';

                    if (isset($_SESSION['events'][$date_str])) {
                        $event = $_SESSION['events'][$date_str];
                        $lesson = htmlspecialchars($event['lesson']);
                        $instructor = htmlspecialchars($event['instructor']);

                        if ($type === "Admin" || $instructor == $id2) {
                            $class .= ' event';
                            $class .= " instructor-$instructor";
                            echo "<div class=\"$class\">$day";

                            $conn = mysqli_connect("localhost","root","","dbdrive");
                            $sql = "SELECT InstRef,First_Name, Surname FROM tbl_instructors WHERE InstRef = $instructor";

                            $result = mysqli_query($conn, $sql);

                            // Check if any records were returned
                            if (mysqli_num_rows($result) > 0) {
                                // Populate dropdown options
                                while($row = mysqli_fetch_assoc($result)) {
                                    $instructor= $row['First_Name'].' '.$row['Surname'];
                                }
                            }
                            echo "<br><small>$instructor".":"."</small>";
                            echo "<br><small>$lesson</small>";
                            echo "</div>";
                        }
                    } else {
                        if ($day == $current_day && $month == $current_month && $year == $current_year) {
                            $class .= ' current';
                        }
                        echo "<div class=\"$class\">$day</div>";
                    }
                }
                ?>
            </div>
        </div>

        <div class="reminder-container">
            <h2>Reminders</h2>
            <ul class="reminder-list">
                <?php
                $conn = mysqli_connect("localhost", "root", "", "dbdrive");

                if ($conn) {
                    $current_date = date('Y-m-d');

                    //$sql = "SELECT * FROM tbl_tasks ";
                    $sql =  "SELECT t.* ,
                                    CONCAT(i.First_Name, ' ', i.Surname) AS InstName
                            FROM 
                                    tbl_tasks t
                            INNER JOIN 
                                    tbl_instructors i ON t.instructor = i.InstRef";

                    $stmt = mysqli_prepare($conn, $sql);
                    mysqli_stmt_execute($stmt);
                    $result = mysqli_stmt_get_result($stmt);

                    if ($result) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $instName= $row["InstName"];
                            $date = $row['date'];
                            $lesson = htmlspecialchars($row['booking']);
                            $status_class = ($date < $current_date) ? 'past-reminder' : '';

                            echo '<li>';
                            echo '<form action="" method="post" style="display:inline;">';
                            echo "<input type=\"hidden\" name=\"event_date\" value=\"$date\">";
                            echo '<button type="submit" name="delete_event">Delete</button>';
                            echo '</form>';
                            echo '<span class="' . $status_class . '">' .$instName.':</br>'. $lesson . ' (' . $date . ')</span>';
                            echo '</li>';
                        }
                    } else {
                        echo "No reminders found.";
                    }

                    mysqli_close($conn);
                } else {
                    echo "Failed to connect to the database.";
                }
                ?>
            </ul>
        </div>

    </div>
</body>

</html>

