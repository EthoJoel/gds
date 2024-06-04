<head>
    <title>Journal Page</title>
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

    .hidden
    {
        display : none;
    }
    .container {
            margin-top: 20px;
        }
    .radio-container {
        margin-bottom: 10px;
    }
    .input-container {
        margin-top: 10px;
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

        // Check if id is not empty
        if($type=="Admin") {
            // Redirect with id and type parameters
            echo "window.location.replace('../Login/HomePage.php?id2=$id&type=$type');";
        } else {
            // Redirect with parameters
            echo "window.location.replace('journalpage.php?id2=$id&type=$type');";
        }
        ?>
    }
</script>

    
    <h1 align="center" class="display-6 text-center">Journal Table</h1>
    </br>
    
<form class='search-form' method="POST">
    <input type='radio' name='rbtn' value='Text' onclick='display(this)' checked> Name
    <input type='radio' name='rbtn' value='Date' onclick='display(this)'> Date
    <br>
    <div id='textinputcontainer'>
        <label>Name:</label>
        <input type='text' id='textinput' name='textinput' class='search-input' placeholder='Search by Credential'>
    </div>
    <div id='dateinputcontainer' class='hidden'>
        <label>Date:</label>
        <input type='date' id='dateinput' name='dateinput' class='search-input'>
    </div>
    <button type='submit' name='btnSearch' class='search-button'>Search</button>
</form>

<script>
    function display(radio) {
        const datecontainer = document.getElementById('dateinputcontainer');
        const textcontainer = document.getElementById('textinputcontainer');

        if (radio.value == "Text") {
            textcontainer.classList.remove('hidden');
            datecontainer.classList.add('hidden');
        }
        if (radio.value == "Date") {
            datecontainer.classList.remove('hidden');
            textcontainer.classList.add('hidden');
        }
    }

    // Initialize the display based on the default checked radio button
    document.addEventListener('DOMContentLoaded', function() {
        const checkedRadio = document.querySelector('input[name="rbtn"]:checked');
        display(checkedRadio);
    });
</script>

    <form method="POST">
        <table id="tblBtn" align="center">    
            <tr>
            <div class="button-container">
                <button name="btnAll" class="action-button" >Show All</button>
                </div>
            </tr>
        </table>
    </form>

    </br>
    </br>
    <div id="error" align="center" style="color: red;"></div>
        <table id="tbl" class="journal-table" align="center">
            <thead>
                <tr>
                    <th>Instructor</th>
                    <th>Entry Text</th>
                    <th>Entry Date</th>
                    <th>Modify</th>
                </tr>
            </thead>
            <tbody>

<?php
    if(isset($_POST['btnAll']))
    {
        all();
    }

    if(isset($_POST['btnSearch']))
    {
        search();
    }

    function all()
    {
        // Include database connection
        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

        // Check connection
        if (!$conn) 
        {
            echo "<script>document.getElementById('error').innerText = 'Connection Failed' ;</script>";
        }
        else
        {

            $id2 = $_GET["id2"];
            $type = $_GET["type"];

            if($type=="Instructor")
            {
                $sql="SELECT 
                            j.*, 
                            CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                        FROM 
                            journal_entries j 
                        INNER JOIN 
                            tbl_instructors i ON j.instructor_id = i.InstRef
                        WHERE j.instructor_id=$id2";
            }
            {
                $sql="SELECT 
                        j.*, 
                        CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                    FROM 
                        journal_entries j 
                    INNER JOIN 
                        tbl_instructors i ON j.instructor_id = i.InstRef";
            }

            $result= $conn->query($sql);

            $id2 = $_GET["id2"];
            $type = $_GET["type"];

           // Check if there are results
            if ($result->num_rows > 0) {
                
                while ($row = $result->fetch_assoc()) 
                {
                    echo "<tr>";
                        echo "<td>" . $row['Instructor_Name'] . "</td>";
                        echo "<td>" . $row['entry_text'] . "</td>";
                        echo "<td>" . $row['entry_date'] . "</td>";
                        echo "<td>
                                <a href='jMod.php?id2=".$id2."&type=".$type."&jid=".urlencode($row['journal_id'])."&iid=".urlencode($row['instructor_id'])."&date=".urlencode($row['entry_date'])."&text=".urlencode($row['entry_text'])."'class='action-button''>Modify</a>
                              </td>";
                        echo "</tr>";
                }
                
            }
           else
           {
            echo"document.getElementById('error').innerText='No Records found'";
           }
           
        }
    }//all()

    function search()
    {
        // Include database connection
        $conn = mysqli_connect("localhost", "root", "", "dbdrive");

        // Check connection
        if (!$conn) {
            echo "<script>document.getElementById('error').innerText = 'Connection Failed';</script>";
            return;
        }

        // Initialize variables
        $date = isset($_POST["dateinput"]) ? $_POST["dateinput"] : '';
        $text = isset($_POST["textinput"]) ? $_POST["textinput"] : '';
        $id2 = isset($_GET["id2"]) ? $_GET["id2"] : '';
        $type = isset($_GET["type"]) ? $_GET["type"] : '';

        // Build the SQL query based on input type
        if (!empty($text)) {
            $sql = "SELECT 
                        j.*, 
                        CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                    FROM 
                        journal_entries j 
                    INNER JOIN 
                        tbl_instructors i ON j.instructor_id = i.InstRef
                    WHERE LOWER(CONCAT(i.First_Name, ' ', i.Surname)) LIKE LOWER('%$text%')";
        } elseif (!empty($date)) {
            $sql = "SELECT 
                        j.*, 
                        CONCAT(i.First_Name, ' ', i.Surname) AS Instructor_Name
                    FROM 
                        journal_entries j 
                    INNER JOIN 
                        tbl_instructors i ON j.instructor_id = i.InstRef
                    WHERE j.entry_date = '$date'";
        } else {
            echo "<script>document.getElementById('error').innerText = 'Please provide search criteria.';</script>";
            return;
        }

        // Execute the query
        $result = $conn->query($sql);

        // Check if there are results
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                    echo "<td>" . $row['Instructor_Name'] . "</td>";
                    echo "<td>" . $row['entry_text'] . "</td>";
                    echo "<td>" . $row['entry_date'] . "</td>";
                    echo "<td>
                            <a href='jMod.php?id2=".$id2."&type=".$type."&jid=".urlencode($row['journal_id'])."&iid=".urlencode($row['instructor_id'])."&date=".urlencode($row['entry_date'])."&text=".urlencode($row['entry_text'])."'class='action-button''>Modify</a>
                          </td>"; 
                echo "</tr>";
            }
        } else {
            echo "<script>document.getElementById('error').innerText = 'No Records found';</script>";
        }

        // Close the connection
        $conn->close();
    }



?>

            </tbody>
        </table>
</body>

</html>