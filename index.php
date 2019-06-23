<html>
 <head>
 <Title>Registration Form</Title>
 <style type="text/css">
 	body { background-color: #fff; border-top: solid 10px #000;
 	    color: #333; font-size: .85em; margin: 20; padding: 20;
 	    font-family: "Segoe UI", Verdana, Helvetica, Sans-Serif;
 	}
 	h1, h2, h3,{ color: #000; margin-bottom: 0; padding-bottom: 0; }
 	h1 { font-size: 2em; }
 	h2 { font-size: 1.75em; }
 	h3 { font-size: 1.2em; }
 	table { margin-top: 0.75em; }
 	th { font-size: 1.2em; text-align: left; border: none; padding-left: 0; }
 	td { padding: 0.25em 2em 0.25em 0em; border: 0 none; }
 </style>
  <style>
#customers {
  font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 80%;
}
#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 8px;
}
#customers tr:nth-child(even){background-color: #f2f2f2;}
#customers tr:hover {background-color: #ddd;}
#customers th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
.button {
  background-color: #4CAF50; /* Green */
  border: none;
  color: white;
  padding: 15px 32px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 14px;
}
</style>
  
 </head>
 <body>
 <h1>Register here!</h1>
 <p>Fill in your name and email address, then click <strong>Submit</strong> to register.</p>
 <form method="post" action="index.php" enctype="multipart/form-data" >
       Name  <input type="text" name="name" id="name"/></br></br>
       Email <input type="text" name="email" id="email"/></br></br>
       Job <input type="text" name="job" id="job"/></br></br>
       Phone <input type="text" name="phone" id="phone"/></br></br>

       <input type="submit" name="submit" value="Submit" />
       <input type="submit" name="load_data" value="Load Data" />
 </form>
 <?php
 
// PHP Data Objects(PDO) Sample Code:
try {
    $conn = new PDO("sqlsrv:server = tcp:herwin.database.windows.net,1433; Database = dicodingdb", "e30nx", "K@nwil0199");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}  

// SQL Server Extension Sample Code:
//$connectionInfo = array("UID" => "e30nx", "pwd" => "K@nwil0199", "Database" => "dicodingdb", "LoginTimeout" => 30, "Encrypt" => 1, "TrustServerCertificate" => 0);
//$serverName = "tcp:herwin.database.windows.net,1433";
//$conn = sqlsrv_connect($serverName, $connectionInfo);

    if (isset($_POST['submit'])) {
        try {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $job = $_POST['job'];
            $date = date("Y-m-d");
            $phone = $_POST['phone'];
            // Insert data
            $sql_insert = "INSERT INTO Registration (name, email, job, date, phone) 
                        VALUES (?,?,?,?,?)";
            $stmt = $conn->prepare($sql_insert);
            $stmt->bindValue(1, $name);
            $stmt->bindValue(2, $email);
            $stmt->bindValue(3, $job);
            $stmt->bindValue(4, $date);
          $stmt->bindValue(5, $phone);
            $stmt->execute();
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
        echo "<h3>Your're registered!</h3>";
    } else if (isset($_POST['load_data'])) {
        try {
            $sql_select = "SELECT * FROM Registration";
            $stmt = $conn->query($sql_select);
            $registrants = $stmt->fetchAll(); 
            if(count($registrants) > 0) {
                echo "<h2>People who are registered:</h2>";
                echo "<table id=customers>";
                echo "<tr><th>Name</th>";
                echo "<th>Email</th>";
                echo "<th>Job</th>";
            
                echo "<th>Date</th></tr>";
                echo "<th>Phone</th>";
                foreach($registrants as $registrant) {
                    echo "<tr><td>".$registrant['name']."</td>";
                    echo "<td>".$registrant['email']."</td>";
                    echo "<td>".$registrant['job']."</td>";
                    echo "<td>".$registrant['date']."</td></tr>";
                    echo "<td>".$registrant['phone']."</td>";

                }
                echo "</table>";
            } else {
                echo "<h3>No one is currently registered.</h3>";
            }
        } catch(Exception $e) {
            echo "Failed: " . $e;
        }
    }
 ?>
 </body>
</html>
