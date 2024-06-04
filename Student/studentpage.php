<head>
    <title>Student Page</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<link rel="stylesheet" href="page.css">
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
        // Retrieve and sanitize the id and type  parameters
        $id = isset($_GET["id2"]) ? htmlspecialchars($_GET["id2"]) : "";
        $type = isset($_GET["type"]) ? htmlspecialchars($_GET["type"]) : "";

         echo "window.location.replace('../Login/HomePage.php?id2=$id&type=$type');";
         
        ?>
    }
</script>

    
    <h1 align="center" class="display-6 text-center">Student Table</h1>
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
                <button type="button"  id="addbtn" class="action-button" onclick="addpage()" >Add Student</button>
                <button name="btnPass" class="action-button" onclick="callPHPFunction('passed')">Show Passed</button>
                <button name="btnAct" class="action-button" onclick="callPHPFunction('active')">Show Active</button>
             </div>
            </tr>
        </table>
    </form>

<script>
    function addpage()
    {     
        <?php 
            // Retrieve and sanitize the id and type parameters
            $id = isset($_GET["id2"]) ? htmlspecialchars($_GET["id2"]) : "";
            $type = isset($_GET["type"]) ? htmlspecialchars($_GET["type"]) : "";

            // Check if id is not empty
            if($type=="Instructor") {
                // Redirect with id and type parameters
                echo "window.location.replace('stdInsert.php?id2=$id & type=$type');";
            } else {
                // Redirect without parameters
                echo "window.location.replace('stdInsert.php?id2=$id & type=$type');";
            }
        ?>
    }//end of function
</script>


    </br>
    </br>
    <Div id="error" align="center" style="color: red;"></Div>
    <table id="tbl" class="student-table" align="center">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Name</th>
                <th>Surname</th>
                <th>I.D</th>
                <th>Phone</th>
                <th>Instructor</th>
                <th>Status</th>
                <th>Address</th>
                <th>Modify</th>
            </tr>
        </thead>
        <tbody>

<?php
    
        if (isset($_POST['btnAll'])) {
            all();
        }

        if (isset($_POST['btnAct'])) {
            activeFunc();
        }

        if (isset($_POST['btnPass'])) {
            passedFunc();
        }

        if (isset($_POST['btnSearch'])) {
            search();
        }

        function search()
        {

            $conn = mysqli_connect("localhost", "root", "", "dbdrive");

            // Check connection
            if (!$conn) {
                echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
            }
            
            $search = $_POST["txtSearch"];

            $id = $_GET["id2"];
            $type = $_GET["type"];

            if($type=="Instructor")
            {   // If user is an instructor, only show their students
                $sql = "SELECT 
                        s.*, 
                        CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                    FROM 
                        tbl_students s 
                    INNER JOIN 
                        tbl_instructors i ON s.Instructor = i.InstRef
                    WHERE (LOWER(s.std_Reference) LIKE LOWER('%$search%')
                            OR LOWER(s.First_Name) LIKE LOWER('%$search%')
                            OR LOWER(s.Surname) LIKE LOWER('%$search%')
                            OR LOWER(s.Phone) LIKE LOWER('%$search%')
                            OR LOWER(s.ID) = LOWER('$search')
                            OR LOWER(s.Address) LIKE LOWER('%$search%'))
                    AND s.Instructor = $id";

            }//end of if
            else
            {
                $sql = "SELECT 
                        s.*, 
                        CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                    FROM 
                        tbl_students s 
                    INNER JOIN 
                        tbl_instructors i ON s.Instructor = i.InstRef
                    WHERE LOWER(s.std_Reference) LIKE LOWER('%$search%')
                    OR LOWER(s.First_Name) LIKE LOWER('%$search%')
                    OR LOWER(s.Surname) LIKE LOWER('%$search%')
                    OR LOWER(s.Phone) LIKE LOWER('%$search%')
                    OR LOWER(s.ID) = LOWER('$search')
                    OR LOWER(s.Address) LIKE LOWER('%$search%')
                    OR LOWER(CONCAT(i.First_Name, ' ', i.Surname)) LIKE LOWER('%$search%')";

            }
            
            $result = $conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) 
                {      
                    echo "<tr>";
                    echo "<td>" . $row['std_Reference'] . "</td>";
                    echo "<td>" . $row['First_Name'] . "</td>";
                    echo "<td>" . $row['Surname'] . "</td>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['Phone'] . "</td>";
                    echo "<td>" . $row['Instructor_Name'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "<td><a type='button' id='btnMod' class='action-button' href='stdModify.php?ref=" . $row['std_Reference'] . "&name=" . urlencode($row['First_Name']) . "&surname=" . urlencode($row['Surname']) . "&id=" . urlencode($row['ID']) . "&phone=" . urlencode($row['Phone']) . "&officer=" . urlencode($row['Instructor_Name']) . "&status=" . urlencode($row['Status']) . "&address=" . urlencode($row['Address']) ."&id2=". urlencode($id)."&type=". urlencode($type) ."'>Modify</a></td>";
                    echo "</tr>";

                } //end of while

            }
            else 
            {
                echo "<script>document.getElementById('error').innerText = 'No records found' ;</script>";
            }

            // Close connection
            $conn->close();

        }//search

        function all()
        {
            $conn = mysqli_connect("localhost", "root", "", "dbdrive");

            if (!$conn) {
                echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
            }

            $id = $_GET["id2"];
            $type = $_GET["type"];

            if ($type == "Instructor") {
                $sql = "SELECT 
                            s.*, 
                            CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                        FROM 
                            tbl_students s 
                        INNER JOIN 
                            tbl_instructors i ON s.Instructor = i.InstRef
                        WHERE
                            s.Instructor = $id ";
            } else {
                $sql = "SELECT 
                            s.*, 
                            CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                        FROM 
                            tbl_students s 
                        INNER JOIN 
                            tbl_instructors i ON s.Instructor = i.InstRef";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    
                    echo "<tr>";
                    echo "<td>" . $row['std_Reference'] . "</td>";
                    echo "<td>" . $row['First_Name'] . "</td>";
                    echo "<td>" . $row['Surname'] . "</td>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['Phone'] . "</td>";
                    echo "<td>" . $row['Instructor_Name'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "<td><a type='button' id='btnMod' class='action-button' href='stdModify.php?ref=" . $row['std_Reference'] . "&name=" . urlencode($row['First_Name']) . "&surname=" . urlencode($row['Surname']) . "&id=" . urlencode($row['ID']) . "&phone=" . urlencode($row['Phone']) . "&officer=" . urlencode($row['Instructor_Name']) . "&status=" . urlencode($row['Status']) . "&address=" . urlencode($row['Address']) . "&id2=" . urlencode($id) . "&type=" . urlencode($type) . "'>Modify</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<script>document.getElementById('error').innerText = 'No records found' ;</script>";
            }

            $conn->close();
        }

        function passedFunc()
        {
            $conn = mysqli_connect("localhost", "root", "", "dbdrive");

            // Check connection
            if (!$conn) {
                echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
            }
            
            $id = $_GET["id2"];
            $type=$_GET["type"];

            if($type=="Instructor")
            {
                $sql = "SELECT 
                        s.*, 
                        CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                    FROM 
                        tbl_students s 
                    INNER JOIN 
                        tbl_instructors i ON s.Instructor = i.InstRef
                    WHERE 
                        s.Status = 'Passed'
                    AND 
                        s.Instructor = $id";
            }
            else
            {
                $sql = "SELECT 
                        s.*, 
                        CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                    FROM 
                        tbl_students s 
                    INNER JOIN 
                        tbl_instructors i ON s.Instructor = i.InstRef
                    WHERE 
                        s.Status = 'Passed'";
            }

            $result = $conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['std_Reference'] . "</td>";
                    echo "<td>" . $row['First_Name'] . "</td>";
                    echo "<td>" . $row['Surname'] . "</td>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['Phone'] . "</td>";
                    echo "<td>" . $row['Instructor_Name'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "<td><a type='button' id='btnMod' class='action-button' href='stdModify.php?ref=" . $row['std_Reference'] . "&name=" . urlencode($row['First_Name']) . "&surname=" . urlencode($row['Surname']) . "&id=" . urlencode($row['ID']) . "&phone=" . urlencode($row['Phone']) . "&officer=" . urlencode($row['Instructor_Name']) . "&status=" . urlencode($row['Status']) . "&address=" . urlencode($row['Address']) ."&id2=". urlencode($id)."&type=". urlencode($type) ."'>Modify</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<script>document.getElementById('error').innerText = 'No records found' ;</script>";
            }

            // Close connection
            $conn->close();
        }

        function activeFunc()
        {
            $conn = mysqli_connect("localhost", "root", "", "dbdrive");

            // Check connection
            if (!$conn) {
                echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
            }
            
            $id = $_GET["id2"];
            $type=$_GET["type"];
            
            if($type=="Instructor")
            {
                $sql = "SELECT 
                        s.*, 
                        CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                    FROM 
                        tbl_students s 
                    INNER JOIN 
                        tbl_instructors i ON s.Instructor = i.InstRef
                    WHERE 
                        s.Status = 'Active'
                    AND 
                        s.Instructor = $id";
            }
            else
            {
                $sql = "SELECT 
                        s.*, 
                        CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                    FROM 
                        tbl_students s 
                    INNER JOIN 
                        tbl_instructors i ON s.Instructor = i.InstRef
                    WHERE 
                        s.Status = 'Active'";
            }

            $result = $conn->query($sql);

            // Check if there are results
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "<tr>";
                    echo "<td>" . $row['std_Reference'] . "</td>";
                    echo "<td>" . $row['First_Name'] . "</td>";
                    echo "<td>" . $row['Surname'] . "</td>";
                    echo "<td>" . $row['ID'] . "</td>";
                    echo "<td>" . $row['Phone'] . "</td>";
                    echo "<td>" . $row['Instructor_Name'] . "</td>";
                    echo "<td>" . $row['Status'] . "</td>";
                    echo "<td>" . $row['Address'] . "</td>";
                    echo "<td><a type='button' id='btnMod' class='action-button' href='stdModify.php?ref=" . $row['std_Reference'] . "&name=" . urlencode($row['First_Name']) . "&surname=" . urlencode($row['Surname']) . "&id=" . urlencode($row['ID']) . "&phone=" . urlencode($row['Phone']) . "&officer=" . urlencode($row['Instructor_Name']) . "&status=" . urlencode($row['Status']) . "&address=" . urlencode($row['Address']) ."&id2=". urlencode($id)."&type=". urlencode($type) ."'>Modify</a></td>";
                    echo "</tr>";
                }
            } else {
                echo "<script>document.getElementById('error').innerText = 'No records found' ;</script>";
            }

            // Close connection
            $conn->close();
        }//end of function

?>

        </tbody>
    </table>
    
</body>

</html>