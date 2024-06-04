<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    
<style>

    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
    }

    header {
        background-color: #333;
        color: #fff;
        text-align: center;
        padding: 20px 0;
    }

    .container {
        display: flex;
        flex-wrap: wrap;
        justify-content: center;
        padding: 20px;
    }

    .category {
        text-align: center;
        margin: 10px;
    }

    .category img {
        width: 100px; /* Adjust the size of the icons as needed */
    }

    .category p {
        margin: 5px 0;
        font-size: 14px;
    }

    /* Hover effect */
    .category:hover {
        transform: scale(1.1);
        transition: transform 0.3s ease;
    }

    
<?php
    // Get user type from URL parameter
    $type = $_GET['type'];
    $id = $_GET['id2'];

    // Define an array of categories to hide based on user type
    $hiddenCategories = [];

    // Add categories to hide based on user type
    if ($type === 'Instructor') {
        $hiddenCategories[] = '.ticket'; // Hide Ticket Panel category for Instructors
        //$hiddenCategories[] = '.messages'; // Hide Ticket Panel category for Instructors
        $hiddenCategories[] = '.tasks'; // Hide Ticket Panel category for Instructors
        $hiddenCategories[] = '.users'; // Hide Ticket Panel category for Instructors
    }

    // Output CSS to hide categories
    foreach ($hiddenCategories as $category) {
        echo "$category { display: none; }";
    }
?>

</style>

</head>
<body>

    <header>
        <h1>Welcome to Gregory's Driving School</h1>
    </header>

    <div class="container">
        <div class="category student">
        <a href="../Student/studentpage.php?id2=<?php echo $id;?>&type=<?php echo $type; ?>">
                <img src="../image/graduated.png" alt="Student Icon">
            </a>
            <p>Students</p>
        </div>

        <div class="category instructor">
            <a href="../Instructor/instructorpage.php?id2=<?php echo $id;?>&type=<?php echo $type;?>">
                <img src="../image/teacher.png" alt="Teacher Icon">
            </a>
            <p>Instructors</p>
        </div>

        <div class="category vehicle">
            <a href="../Vechicle/vechiclepage.php?id2=<?php echo $id;?>&type=<?php echo $type;?>">
                <img src="../image/car.png" alt="Vehicle Icon">
            </a>
            <p>Vehicle Information</p>
        </div>
        
        <div class="category ticket">
            <a href="../Tickets/ticketspage.php?id2=<?php echo $id;?>&type=<?php echo $type;?>">
                <img src="../image/ticket.png" alt="Tickets Icon">
            </a>
            <p>Tickets</p>
        </div>

        <div class="category booking">
            <a href="../Bookings/bookingpage.php?id2=<?php echo $id;?>&type=<?php echo $type;?>">
                <img src="../image/schedule.png" alt="Tasks Icon">
            </a>
            <p>Booking</p>
        </div>

        <div class="category journal">
            <?php
                if($type=="Instructor")
                    {
                        echo"<a href='../Journal/journalpage.php?id2=$id&type=$type'>";
                    }
                else
                    {
                        echo"<a href='../Journal/jread.php?id2=$id&type=$type'>";
                    }
            ?>
                <img src="../image/diary.png" alt="Diary Icon">
            </a>
            <p>Journal</p>
        </div>

        <div class="category messages">
            <a href="../Message/messagepage.php">
            <img src="../image/bubble-chat.png" alt="Message icon">
            </a>
            <p>Messages</p>
        </div>
        <div class="category users">
            <a href="../Users/userspage.php?id2=<?php echo $id;?>&type=<?php echo $type;?>">
            <img src="../image/user.png" alt="Message icon">
            </a>
            <p>Users</p>
        </div>

        <div class="category doc">
            <img src="../image/document.png" alt="Company Document Icon">
            <p>Company Documents</p>
        </div>

    </div>
</body>
</html>
