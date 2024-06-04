<head>
    <title>Instructor Page</title>
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

    <!-- Background image container -->
    <div class="background-container"></div>

    <h1 align="center" class="display-6 text-center">Instructor Table</h1>
    </br>
  
    <?php
        $type=$_GET["type"];

        if($type!=="Instructor")
        {
            echo " 
            <form method='POST' class='search-form'>
            <input type='text' placeholder='Search by Credential' name='txtSearch' class='search-input'>
            <button type='submit' name='btnSearch' class='search-button'>Search</button>   
            </form>
            ";
        }
    ?>
    
    <form method="POST">
        <table id="tblBtn" align="center">    
            <tr>
            <div class="button-container">
                <button name="btnAll" class="action-button" onclick="callPHPFunction('all')">Show All</button>

                <?php
                    $type = $_GET["type"];
                    $id2 = $_GET["id2"];

                    if($type=="Admin")
                    {
                        echo "<button type='button' id='addbtn' class='action-button' onclick='addpage()' >Add Instructor</button>";
                    }
                     ?>
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

                echo "window.location.replace('instInsert.php?id2=$id2&type=$type');";
            ?>
        }//end of function
    </script>

    </br>
    </br>
    
    <p id="error" align="center" style="color:red;"></p>
    <table id="tbl" class="instructor-table" align="center">
        <thead>
            <tr>
                <th>Reference</th>
                <th>Name</th>
                <th>Surname</th>
                <th>I.D</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Password</th>
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

    function search()
    {

        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

        // Check connection
        if (!$conn) {
            echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
        }
        
        $search = $_POST["txtSearch"];

        $id2 = $_GET["id2"];
        $type = $_GET["type"];
        
        $sql = "SELECT * FROM tbl_instructors
                WHERE LOWER(InstRef) LIKE LOWER('%$search%')
                    OR LOWER(First_Name) LIKE LOWER('%$search%')
                    OR LOWER(Surname) LIKE LOWER('%$search%')
                    OR LOWER(Address) LIKE LOWER('%$search%')
                    OR (Phone) LIKE ('%$search%');";

        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) 
            {      
                echo "<tr>";
                echo "<td>" . $row['InstRef'] . "</td>";
                echo "<td>" . $row['First_Name'] . "</td>";
                echo "<td>" . $row['Surname'] . "</td>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['Phone'] . "</td>";
                echo "<td>" . $row['Address'] . "</td>";
                echo "<td>" . $row['Password'] . "</td>";
                echo "<td><a type='button' id='btnMod' class='action-button' href='instMod.php?ref=" . $row['InstRef'] . "&name=" . urlencode($row['First_Name']) . "&surname=" . urlencode($row['Surname']) . "&id=" . urlencode($row['ID']) . "&phone=" . urlencode($row['Phone']) . "&address=" . urlencode($row['Address']) . "&password=" . urlencode($row['Password']) ."&id2=".$id2."&type=".$type. "'>Modify</a></td>";
                echo "</tr>";

            } //end of while

        }
        else 
        {
            echo "<script>document.getElementById('error').innerText = 'No Records found' ;</script>";
        }

        // Close connection
        $conn->close();

    }//search

    function all()
    {
        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

        // Check connection
        if (!$conn) {
            echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
        }

        $id2 = $_GET["id2"];
        $type = $_GET["type"];

        if($type=="Instructor")
        {
            $sql = "SELECT * FROM tbl_instructors WHERE InstRef = '$id2' ";
           
        }
        else
        {
            $sql = "SELECT * FROM tbl_instructors";
        }

        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) 
            {      
                echo "<tr>";
                echo "<td>" . $row['InstRef'] . "</td>";
                echo "<td>" . $row['First_Name'] . "</td>";
                echo "<td>" . $row['Surname'] . "</td>";
                echo "<td>" . $row['ID'] . "</td>";
                echo "<td>" . $row['Phone'] . "</td>";
                echo "<td>" . $row['Address'] . "</td>";
                echo "<td>" . $row['Password'] . "</td>";
                echo "<td><a type='button' id='btnMod' class='action-button' href='instMod.php?ref=" . $row['InstRef'] . "&name=" . urlencode($row['First_Name']) . "&surname=" . urlencode($row['Surname']) . "&id=" . urlencode($row['ID']) . "&phone=" . urlencode($row['Phone']) . "&address=" . urlencode($row['Address']) . "&password=" . urlencode($row['Password']) ."&id2=".$id2."&type=".$type ."'>Modify</a></td>";
                
                echo "</tr>";

            } //end of while

        }
        else 
        {
            echo "<script>document.getElementById('error').innerText = 'No Records Found' ;</script>";
        }

        // Close connection
        $conn->close();
    }//all


?>

        </tbody>
    </table>
    
</body>

</html>