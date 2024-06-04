<head>
<title>Vehicle Page</title>
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

<h1 align="center" class="display-6 text-center">Vehicle Table</h1>
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
    <button type="button"  id="addbtn" class="action-button" onclick="addpage()" >Add Vehicle</button>
    </div>
</tr>
</table>
</form>

<script>
    function addpage()
    {
        <?php
            $id=$_GET["id2"];
            $type=$_GET["type"];

            echo "window.location.replace('vehInsert.php?id2=$id&type=$type');";
        ?> 
    }//end of function
</script>

</br>
</br>
<div id="error" align="center" style="color:red;"></div>
<table id="tbl" class="vehicle-table" align="center">
<thead>
<tr>
    <th>Reference</th>
    <th>Brand</th>
    <th>Registration Number</th>
    <th>VIN</th>
    <th>Color</th>
    <th>Driver</th>
    <th>Notes</th>
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
        $id=$_GET["id2"]; //id of the instructor
        $type=$_GET["type"];

        if($type=="Instructor")
        {
            
            $sql = "SELECT 
                v.*, 
                CONCAT(i.First_Name, ' ', i.Surname) AS Driver_Name
            FROM 
                tbl_vechicles v 
            INNER JOIN 
                tbl_instructors i ON v.Driver = i.InstRef
            WHERE LOWER(vecRef) LIKE LOWER('%$search%')
            OR LOWER(Brand) LIKE LOWER('%$search%')
            OR LOWER(RegNo) LIKE LOWER('%$search%')
            OR LOWER(VIN) LIKE LOWER('%$search%')
            OR LOWER(Color) LIKE LOWER('%$search%')
            OR LOWER(CONCAT(i.First_Name, ' ', i.Surname)) LIKE LOWER('%$search%')
            OR (Notes) LIKE ('%$search%')
            AND v.Driver = $id";

        }
        else
        {
            $sql = "SELECT 
                    v.*, 
                    CONCAT(i.First_Name, ' ', i.Surname) AS Driver_Name
                FROM 
                    tbl_vechicles v 
                INNER JOIN 
                    tbl_instructors i ON v.Driver = i.InstRef
                 WHERE LOWER(vecRef) LIKE LOWER('%$search%')
                OR LOWER(Brand) LIKE LOWER('%$search%')
                OR LOWER(RegNo) LIKE LOWER('%$search%')
                OR LOWER(VIN) LIKE LOWER('%$search%')
                OR LOWER(Color) LIKE LOWER('%$search%')
                OR LOWER(CONCAT(i.First_Name, ' ', i.Surname)) LIKE LOWER('%$search%')
                OR (Notes) LIKE ('%$search%')";

        }
        

        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) 
            {      
                echo "<tr>";
                echo "<td>" . $row['vecRef'] . "</td>";
                echo "<td>" . $row['Brand'] . "</td>";
                echo "<td>" . $row['RegNo'] . "</td>";
                echo "<td>" . $row['VIN'] . "</td>";
                echo "<td>" . $row['Color'] . "</td>";
                echo "<td>" . $row['Driver_Name'] . "</td>";
                echo "<td>" . $row['Notes'] . "</td>";
                echo "<td><a type='button' id='btnMod' class='action-button' href='vehMod.php?ref=" . $row['vecRef'] . "&brand=" . urlencode($row['Brand']) . "&reg=" . urlencode($row['RegNo']) . "&vin=" . urlencode($row['VIN']) . "&color=" . urlencode($row['Color']) . "&driver=" . urlencode($row['Driver']) . "&notes=" . urlencode($row['Notes']) ."&id2=". $id ."&type=".$type. "'>Modify</a></td>";
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

        // Check connection
        if (!$conn) {
            echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
        }

        $id= $_GET["id2"];
        $type= $_GET["type"];

        if($type=="Instructor")
        {
            $sql = "SELECT 
                    v.*, 
                    CONCAT(i.First_Name, ' ', i.Surname) AS Driver_Name
                FROM 
                    tbl_vechicles v 
                INNER JOIN 
                    tbl_instructors i ON v.Driver = i.InstRef
                WHERE
                    v.Driver = $id";
        }
        else
        {
            $sql = "SELECT 
                    v.*, 
                    CONCAT(i.First_Name, ' ', i.Surname) AS Driver_Name
                FROM 
                    tbl_vechicles v 
                INNER JOIN 
                    tbl_instructors i ON v.Driver = i.InstRef";
        
        }
        

        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) 
            {      
                echo "<tr>";
                echo "<td>" . $row['vecRef'] . "</td>";
                echo "<td>" . $row['Brand'] . "</td>";
                echo "<td>" . $row['RegNo'] . "</td>";
                echo "<td>" . $row['VIN'] . "</td>";
                echo "<td>" . $row['Color'] . "</td>";
                echo "<td>" . $row['Driver_Name'] . "</td>";
                echo "<td>" . $row['Notes'] . "</td>";
                echo "<td><a type='button' id='btnMod' class='action-button' href='vehMod.php?ref=" . $row['vecRef'] . "&brand=" . urlencode($row['Brand']) . "&reg=" . urlencode($row['RegNo']) . "&vin=" . urlencode($row['VIN']) . "&color=" . urlencode($row['Color']) . "&driver=" . urlencode($row['Driver']) . "&notes=" . urlencode($row['Notes']) ."&id2=". $id ."&type=".$type. "'>Modify</a></td>";
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


?>

</tbody>
</table>

</body>

</html>