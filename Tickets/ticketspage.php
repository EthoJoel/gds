<head>
    <title>Tickets Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<link rel="stylesheet" href="design.css">
<style>
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

<body id="body">

    <!-- Background image container -->
    <div class="background-container"></div>

    <button class="back" value="Back" onclick="back()">Back</button>

<script>    
    function back() {   
        <?php 
        // Retrieve and sanitize the id and type parameters
        $id = isset($_GET["id2"]) ? htmlspecialchars($_GET["id2"]) : "";
        $type = isset($_GET["type"]) ? htmlspecialchars($_GET["type"]) : "";

        echo "window.location.replace('../Login/HomePage.php?id2=$id&type=$type');";
       
        ?>
    }
</script>

    <h1 align="center" class="display-6 text-center">Tickets Table</h1>
    </br>
  

    <form method="POST" class="search-form">
        <input type="text" placeholder="Search by Credential" name="txtSearch" class="search-input">
        <button type="submit" name="btnSearch" class="search-button">Search</button>   
    </form>

    <form method="POST">
        <table id="tblBtn" align="center">    
            <tr>
            <div class="button-container">
                <button name="btnAll" class="action-button" onclick="callPHPFunction('all')">Show All</button>
                <button type="button"  id="addbtn" class="action-button" onclick="addpage()" >Add Ticket</button>
                <button name="btnUnread" id="btnUnread" class="action-button">Unread</button>
                <button name="btnPro" id="btnPro" class="action-button">Processing</button>
                <button name="btnRead" id="btnRead" class="action-button">Read</button>
            </div>
            </tr>
        </table>
    </form>

    <script>
        function addpage()
        {
            <?php 
                $id2 = $_GET["id2"];
                $type = $_GET["type"];

                echo "window.location.replace('tInsert.php?id2=$id2&type=$type');";
            ?>
        }//end of function

        
    </script>

    </br>
    </br>
    <div id="error" align="center" style="color:red;" ></div>
    
    <table id="tbl" class="student-table" align="center">
        <thead>
            <tr>
                <th>Query Id</th>
                <th>Student</th>
                <th>Complaint</th>
                <th>Instructor</th>
                <th>Status</th>
                <th>Date</th>
                <th>Modify</th>
            </tr>
        </thead>
        <tbody>

        <?php
            
                if (isset($_POST['btnAll'])) {
                    all();
                }
       
                if (isset($_POST['btnSearch'])) {
                    search();
                }

                if (isset($_POST['btnUnread'])) {
                    unreadFunc();
                }
                
                if (isset($_POST['btnPro'])) {
                    processFunc();
                }
                
                if (isset($_POST['btnRead'])) {
                    readFunc();
                }

                function search()
                {

                    $conn = mysqli_connect("localhost", "root", "", "dbdrive");
    
                    // Check connection
                    if (!$conn) {
                        echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
                    }
                    
                    $search = $_POST["txtSearch"];


                    if(!$search)
                    {
                        echo "<script>document.getElementById('error').innerText = 'Kindly fill in the search bar' ;</script>";
                    }
                    else
                    {
                        $sql = "SELECT 
                                    t.*, 
                                    CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name,
                                    CONCAT(s.First_Name, ' ', s.Surname) AS Student_Name
                                FROM 
                                    tbl_tickets t
                                INNER JOIN 
                                    tbl_instructors i ON t.Instructor = i.InstRef
                                INNER JOIN 
                                    tbl_students s ON t.Student = s.std_Reference
                                WHERE 
                                    LOWER(t.ticketNo) = LOWER('$search')
                                    OR LOWER(CONCAT(s.First_Name, ' ', s.Surname)) LIKE LOWER('%$search%')
                                    OR LOWER(t.Status) = LOWER('$search')
                                    OR LOWER(CONCAT(i.First_Name, ' ', i.Surname)) LIKE LOWER('%$search%')
                                    OR LOWER(t.`Date`) = LOWER('$search')";

                        $result = $conn->query($sql);
                        
                        $id2 = $_GET["id2"];
                        $type = $_GET["type"];

                        // Check if there are results
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) 
                            {      
                                echo "<tr>";
                                echo "<td>" . $row['ticketNo'] . "</td>";
                                echo "<td>" . $row['Student_Name'] . "</td>";
                                echo "<td>" . $row['Complaint'] . "</td>";
                                echo "<td>" . $row['Instructor_Name'] . "</td>";
                                echo "<td>" . $row['Status'] . "</td>";
                                echo "<td>" . $row['Date'] . "</td>";
                                echo "<td><a type='button' id='btnMod' class='action-button' href='ticketMod.php?ticketNo=" . $row['ticketNo'] . "&std=" . urlencode($row['Student_Name']) . "&complaint=" . urlencode($row['Complaint']) . "&instr=" . urlencode($row['Instructor_Name']) . "&status=" . urlencode($row['Status']) . "&date=" . urlencode($row['Date']) ."&id2=".$id2."&type=".$type."'>Modify</a></td>";
                                echo "</tr>";

                            } //end of while
                        }//end of nested-if
                    
                        else 
                        {
                            echo "<script>document.getElementById('error').innerText = 'No records found' ;</script>";
                        }
                    
                        // Close connection
                        $conn->close();
                    }//end of else
                }//search

                function all()
                {
                    $conn = mysqli_connect("localhost", "root", "", "dbdrive");
    
                    // Check connection
                    if (!$conn) {
                        echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
                    }
    
                    $sql = "SELECT 
                                t.*, 
                                CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name,
                                CONCAT(s.First_Name, ' ', s.Surname) AS Student_Name
                            FROM 
                                tbl_tickets t
                            INNER JOIN 
                                tbl_instructors i ON t.Instructor = i.InstRef
                            INNER JOIN 
                                tbl_students s ON t.Student = s.std_Reference";

                    $result = $conn->query($sql);

                    $id2 = $_GET["id2"];
                    $type = $_GET["type"];
    
                    // Check if there are results
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) 
                        {      
                            echo "<tr>";
                            echo "<td>" . $row['ticketNo'] . "</td>";
                            echo "<td>" . $row['Student_Name'] . "</td>";
                            echo "<td>" . $row['Complaint'] . "</td>";
                            echo "<td>" . $row['Instructor_Name'] . "</td>";
                            echo "<td>" . $row['Status'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "<td><a type='button' id='btnMod' class='action-button' href='ticketMod.php?ticketNo=" . $row['ticketNo'] . "&std=" . urlencode($row['Student_Name']) . "&complaint=" . urlencode($row['Complaint']) . "&instr=" . urlencode($row['Instructor_Name']) . "&status=" . urlencode($row['Status']) . "&date=" . urlencode($row['Date']) ."&id2=".$id2."&type=".$type."'>Modify</a></td>";
                            echo "</tr>";

                        } //end of while

                    }
                    else 
                    {
                        echo "<script>document.getElementById('error').innerText = 'No records found' ;</script>";
                    }

                    // Close connection
                    $conn->close();
                }//all
               
                function unreadFunc()
                {
                    $conn = mysqli_connect("localhost", "root", "", "dbdrive");
    
                    // Check connection
                    if (!$conn) {
                        echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
                    }
    
                    $sql = "SELECT 
                                t.*, 
                                CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name,
                                CONCAT(s.First_Name, ' ', s.Surname) AS Student_Name
                            FROM 
                                tbl_tickets t 
                            INNER JOIN 
                                tbl_instructors i ON t.Instructor = i.InstRef
                            INNER JOIN 
                                tbl_students s ON t.Student = s.std_Reference
                            WHERE
                                t.Status = 'Unread'";
                    

                    $result = $conn->query($sql);
    
                    $id2 = $_GET["id2"];
                    $type = $_GET["type"];

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            
                            echo "<tr>";
                            echo "<td>" . $row['ticketNo'] . "</td>";
                            echo "<td>" . $row['Student_Name'] . "</td>";
                            echo "<td>" . $row['Complaint'] . "</td>";
                            echo "<td>" . $row['Instructor_Name'] . "</td>";
                            echo "<td>" . $row['Status'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "<td><a type='button' id='btnMod' class='action-button' href='ticketMod.php?ticketNo=" . $row['ticketNo'] . "&std=" . urlencode($row['Student_Name']) . "&complaint=" . urlencode($row['Complaint']) . "&instr=" . urlencode($row['Instructor_Name']) . "&status=" . urlencode($row['Status']) . "&date=" . urlencode($row['Date']) ."&id2=".$id2."&type=".$type."'>Modify</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<script>document.getElementById('error').innerText = 'No records found' ;</script>";
                    }
    
                    // Close connection
                    $conn->close();
                }

                function processFunc()
                {
                    $conn = mysqli_connect("localhost", "root", "", "dbdrive");
    
                    // Check connection
                    if (!$conn) {
                        echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
                    }
    
                    $sql = "SELECT 
                                t.*, 
                                CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name,
                                CONCAT(s.First_Name, ' ', s.Surname) AS Student_Name
                            FROM 
                                tbl_tickets t 
                            INNER JOIN 
                                tbl_instructors i ON t.Instructor = i.InstRef
                            INNER JOIN 
                                tbl_students s ON t.Student = s.std_Reference
                            WHERE
                                t.Status = 'Processing'";
                    

                    $result = $conn->query($sql);
    
                    $id2 = $_GET["id2"];
                    $type = $_GET["type"];

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            
                            echo "<tr>";
                            echo "<td>" . $row['ticketNo'] . "</td>";
                            echo "<td>" . $row['Student_Name'] . "</td>";
                            echo "<td>" . $row['Complaint'] . "</td>";
                            echo "<td>" . $row['Instructor_Name'] . "</td>";
                            echo "<td>" . $row['Status'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "<td><a type='button' id='btnMod' class='action-button' href='ticketMod.php?ticketNo=" . $row['ticketNo'] . "&std=" . urlencode($row['Student_Name']) . "&complaint=" . urlencode($row['Complaint']) . "&instr=" . urlencode($row['Instructor_Name']) . "&status=" . urlencode($row['Status']) . "&date=" . urlencode($row['Date']) ."&id2=".$id2."&type=".$type."'>Modify</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<script>document.getElementById('error').innerText = 'No records found' ;</script>";
                    }
    
                    // Close connection
                    $conn->close();
                }
                
                function readFunc()
                {
                    $conn = mysqli_connect("localhost", "root", "", "dbdrive");
    
                    // Check connection
                    if (!$conn) {
                        echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
                    }
    
                    $sql = "SELECT 
                                t.*, 
                                CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name,
                                CONCAT(s.First_Name, ' ', s.Surname) AS Student_Name
                            FROM 
                                tbl_tickets t 
                            INNER JOIN 
                                tbl_instructors i ON t.Instructor = i.InstRef
                            INNER JOIN 
                                tbl_students s ON t.Student = s.std_Reference
                            WHERE
                                t.Status = 'Read'";
                    

                    $result = $conn->query($sql);
    
                    $id2 = $_GET["id2"];
                    $type = $_GET["type"];

                    // Check if there are results
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            
                            echo "<tr>";
                            echo "<td>" . $row['ticketNo'] . "</td>";
                            echo "<td>" . $row['Student_Name'] . "</td>";
                            echo "<td>" . $row['Complaint'] . "</td>";
                            echo "<td>" . $row['Instructor_Name'] . "</td>";
                            echo "<td>" . $row['Status'] . "</td>";
                            echo "<td>" . $row['Date'] . "</td>";
                            echo "<td><a type='button' id='btnMod' class='action-button' href='ticketMod.php?ticketNo=" . $row['ticketNo'] . "&std=" . urlencode($row['Student_Name']) . "&complaint=" . urlencode($row['Complaint']) . "&instr=" . urlencode($row['Instructor_Name']) . "&status=" . urlencode($row['Status']) . "&date=" . urlencode($row['Date']) ."&id2=".$id2."&type=".$type."'>Modify</a></td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<script>document.getElementById('error').innerText = 'No records found' ;</script>";
                    }
    
                    // Close connection
                    $conn->close();
                }

            ?>

        </tbody>
    </table>
   
</body>

</html>